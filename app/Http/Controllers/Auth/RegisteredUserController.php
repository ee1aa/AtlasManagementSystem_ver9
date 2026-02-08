<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

use App\Models\Users\Subjects;
use App\Models\Users\User;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $subjects = Subjects::all();
        return view('auth.register.register', compact('subjects'));
    }

    /**
     * Handle an incoming registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $old_year = $request->old_year;
            $old_month = $request->old_month;
            $old_day = $request->old_day;
            $data = $old_year . '-' . $old_month . '-' . $old_day;
            $birth_day = date('Y-m-d', strtotime($data));
            $request->merge(['birth_day' => $birth_day]);
            $subjects = $request->subject;
            $validated = $request->validate([
                'over_name' => 'required|string|max:10',
                'under_name' => 'required|string|max:10',
                'over_name_kana' => 'required|string|max:30|regex:/\A[ァ-ヴー]+\z/u',
                'under_name_kana' => 'required|string|max:30|regex:/\A[ァ-ヴー]+\z/u',
                'mail_address' => 'required|email|max:100|unique:users,mail_address',
                'sex' => 'required|between:1,3',
                'birth_day' => 'required|after:2000-1-1|before:today|date',
                'role' => 'required|between:1,4',
                'password' => 'required|min:8|max:30|confirmed'
            ]);
            $user_get = User::create([
                'over_name' => $request->over_name,
                'under_name' => $request->under_name,
                'over_name_kana' => $request->over_name_kana,
                'under_name_kana' => $request->under_name_kana,
                'mail_address' => $request->mail_address,
                'sex' => $request->sex,
                'birth_day' => $birth_day,
                'role' => $request->role,
                'password' => bcrypt($request->password)
            ]);
            if ($request->role == 4) {
                $user = User::findOrFail($user_get->id);
                $user->subjects()->attach($subjects);
            }
            DB::commit();
            return view('auth.login.login');
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->route('loginView');
        }
    }
}
