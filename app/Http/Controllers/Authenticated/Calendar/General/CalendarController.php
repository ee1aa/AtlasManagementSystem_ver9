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
            $getPart = $request->getPart;
            $getDate = $request->getData;
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

        auth()->user()
            ->reserveSettings()
            ->detach($request->reserve_setting_id);

        return back();
    }
}
