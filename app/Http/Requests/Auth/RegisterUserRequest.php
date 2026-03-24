<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    protected function prepareForValidation()
    {
        $old_year = $this->old_year;
        $old_month = $this->old_month;
        $old_day = $this->old_day;

        if ($old_year && $old_month && $old_day) {
            $this->merge([
                'birth_day' => sprintf('%04d-%02d-%02d', $old_year, $old_month, $old_day)
            ]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'over_name' => 'required|string|max:10',
            'under_name' => 'required|string|max:10',
            'over_name_kana' => 'required|string|max:30|regex:/\A[ァ-ヴー]+\z/u',
            'under_name_kana' => 'required|string|max:30|regex:/\A[ァ-ヴー]+\z/u',
            'mail_address' => 'required|email|max:100|unique:users,mail_address',
            'sex' => 'required|in:1,2,3',
            'birth_day' => [
                'required',
                'after:2000-1-1',
                'before:today',
                function ($attribute, $value, $fail) {
                    [$y, $m, $d] = explode('-', $value);
                    if (!checkdate((int)$m, (int)$d, (int)$y)) {
                        $fail('※生年月日は正しい日付を入力してください。');
                    }
                }
            ],
            'role' => 'required|in:1,2,3,4',
            'password' => 'required|min:8|max:30|confirmed',
        ];
    }
}
