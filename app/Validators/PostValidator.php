<?php

namespace App\Validators;


use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Validator;

class PostValidator extends Validator
{
    /**
     * Валидация данных их формы при создании и обновлении статьи
     *
     * @param Request $request
     * @param Post|null $post
     * @return array
     * @throws ValidationException
     */
    public function postValidate(Request $request, ?Post $post)
    {
        $validator = Validator::make($request->all(), [
            'title'            => ['required', 'min:5', 'max:100'],
            'shortDescription' => ['required', 'max:255'],
            'body'             => ['required'],
        ]);

        if (isset($post)) {
            $validator->addRules(['slug' => ['required', 'alpha_dash', Rule::unique('posts')->ignore($post->id)]]);
        } else {
            $validator->addRules(['slug' => ['required', 'alpha_dash', Rule::unique('posts')]]);
        }
        return $validator->validate();
    }
}
