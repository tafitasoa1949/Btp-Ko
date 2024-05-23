<?php

namespace App\Http\Requests;

use App\Models\Travail;
use Illuminate\Foundation\Http\FormRequest;

class CreateTravailRequest extends FormRequest
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
        return Travail::$rules;
    }
    public function messages(): array
    {
        return Travail::$messages;
    }
}
