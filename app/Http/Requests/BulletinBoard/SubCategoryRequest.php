<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class SubCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'main_category_id' => 'required|exists:main_categories,id',
            'sub_category_name' => 'required|string|max:100|unique:sub_categories,sub_category',
        ];
    }

    public function messages()
    {
        return [
            'main_category_id.required' => 'メインカテゴリーは必ず選択してください。',
            'main_category_id.exists' => '存在しないカテゴリーです。',
            'sub_category_name.required' => 'サブカテゴリーは必ず入力してください。',
            'sub_category_name.string' => 'サブカテゴリーは文字列である必要があります。',
            'sub_category_name.max' => 'サブカテゴリーは100文字以内で入力してください。',
            'sub_category_name.unique' => '既に登録されているサブカテゴリーです。'
        ];
    }
}
