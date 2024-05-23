<?php

namespace App\Http\Requests;

use App\Models\Finition;
use Illuminate\Foundation\Http\FormRequest;

class CreateFinitionRequest extends FormRequest
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
        return Finition::$rules;
    }
    public function messages(): array
    {
        return Finition::$messages;
    }
}
