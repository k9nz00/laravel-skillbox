<?php

namespace App\Http\Requests\News;

use Illuminate\Validation\Rule;

class UpdateNewsRequest extends StoreNewsRequest
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
        return array_merge(parent::rules(), [
            'slug' => [
                'required',
                'alpha_dash',
                Rule::unique('news')
                    ->ignore(
                        $this->route()
                            ->parameters()['news']->id
                    ),
            ],
        ]);
    }
}
