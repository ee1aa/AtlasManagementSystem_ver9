<?php

namespace App\Http\Requests\BulletinBoard;

use Illuminate\Foundation\Http\FormRequest;

class PostCommentFormRequest extends FormRequest
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
            'comment' => 'required|string|max:150'
        ];
    }

    public function messages()
    {
        return [
            'comment.required' => 'コメントは必ず入力してください。',
            'comment.string' => 'コメントは文字列である必要があります。',
            'comment.max' => 'コメントは150文字以内で入力してください。'
        ];
    }
}
