<?php

namespace App\Http\Requests;

use App\Models\Employe;
use Illuminate\Foundation\Http\FormRequest;

class CreateEmployeRequest extends FormRequest
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
        return Employe::$rules;
    }
    public function messages(): array
    {
        return Employe::$messages;
    }
}
