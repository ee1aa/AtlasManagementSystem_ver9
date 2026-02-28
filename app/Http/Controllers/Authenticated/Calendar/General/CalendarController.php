<?php

namespace App\Http\Controllers\Authenticated\Calendar\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Calendars\General\CalendarView;
use App\Models\Calendars\ReserveSettings;
use App\Models\Calendars\Calendar;
use App\Models\Users\User;
use Auth;
use CreateReserveSettingUsersTable;
use DB;
use Illuminate\Validation\Rule;

class CalendarController extends Controller
{
    public function show()
    {
        $calendar = new CalendarView(time());
        $today = now()->format('Y-m-d');
        return view(
            'authenticated.calendar.general.calendar',
            compact('calendar', 'today')
        );
    }

    public function reserve(Request $request)
    {
        DB::beginTransaction();
        try {
            $getPart = $request->getPart ?? [];
            $getDate = $request->getData ?? [];
            $reserveDays = array_filter(array_combine($getDate, $getPart));
            foreach ($reserveDays as $key => $value) {
                $reserve_settings = ReserveSettings::where('setting_reserve', $key)->where('setting_part', $value)->first();
                $reserve_settings->decrement('limit_users');
                $reserve_settings->users()->attach(Auth::id());
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return redirect()->route('calendar.general.show', ['user_id' => Auth::id()]);
    }

    public function delete(Request $request)
    {
        $request->validate([
            'reserve_setting_id' => [
                'required',
                'integer',
                Rule::exists('reserve_setting_users', 'reserve_setting_id')
                    ->where(fn($q) => $q->where('user_id', auth()->id()))
            ]
        ]);

        DB::beginTransaction();
        try {
            $reserveSettingId = (int) $request->reserve_setting_id;

            // 同時更新対策でロック
            $reserveSettings = ReserveSettings::lockForUpdate()->findOrFail($reserveSettingId);

            // 予約キャンセル（中間テーブル削除）
            auth()->user()->reserveSettings()->detach($reserveSettingId);

            // 枠を戻す
            $reserveSettings->increment('limit_users');

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            // 必要ならエラーメッセージ
            return back();
        }

        return back();
    }
}
