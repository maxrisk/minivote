<?php

namespace App\Http\Requests;

use App\Rules\Sensitivity;
use Illuminate\Foundation\Http\FormRequest;

class StoreVoteRequest extends FormRequest
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
            'title' => ['required', 'min:3', new Sensitivity()],
            'content' => [new Sensitivity()],
            'options' => 'array',
            'options.*.title' => [new Sensitivity()]
        ];
    }
}
