<?php

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => ['required', 'min:5'],
        ];
    }

    /**
     * Сообщения об ошибках валидации
     * @return array
     */
    public function messages()
    {
        return array_merge(parent::messages(), [
            'body.required' => 'Поле :attribute Обязательно для заполнения',
            'body.min' => 'Поле :attribute должно быть больше :min',
        ]);
    }
}
