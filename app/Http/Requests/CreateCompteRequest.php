<?php

namespace App\Http\Requests;

use App\Models\Compte;
use Illuminate\Foundation\Http\FormRequest;

class CreateCompteRequest extends FormRequest
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
        return Compte::$rules;
    }
    public function messages(): array
    {
        return Compte::$messages;
    }
}
