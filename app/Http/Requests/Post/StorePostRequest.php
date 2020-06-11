<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePostRequest extends FormRequest
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
            'title'            => ['required', 'min:5', 'max:100'],
            'shortDescription' => ['required', 'max:255'],
            'body'             => ['required'],
            'slug'             => ['required', 'alpha_dash', Rule::unique('posts')],
        ];
    }

    public function messages()
    {
        return array_merge(parent::messages(), [
            'title.required' => 'Поле :attribute Обязательно для заполнения',
            'title.min' => 'Поле :attribute должно быть больше :min',
            'title.max' => 'Поле :attribute должно быть меньше :max',

            'shortDescription.required' => 'Поле :attribute Обязательно для заполнения',
            'shortDescription.max' => 'Поле :attribute должно быть меньше :max',

            'body.required' => 'Поле :attribute Обязательно для заполнения',

            'slug.required' => 'Поле :attribute Обязательно для заполнения',
            'slug.alpha_dash' => 'Поле :attribute может состоять только из букв английского языка, цифр и символа подчеркивания',
            'slug.unique' => 'Поле :attribute должно быть уникально из списка статей',
        ]);
    }

}
