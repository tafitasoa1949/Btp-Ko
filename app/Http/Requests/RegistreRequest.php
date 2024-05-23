<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegistreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nom' => 'required',
            'prenoms' => 'required',
            'contact' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:4',
            'password_confirmation' => 'required|min:4'
        ];
    }
    public function messages(): array
    {
        return [
            'nom.required' => 'Le champ nom est obligatoire.',
            'prenoms.required' => 'Le champ prénoms est obligatoire.',
            'contact.required' => 'Le champ contact est obligatoire.',
            'email.required' => 'Le champ email est obligatoire.',
            'email.email' => 'Veuillez entrer une adresse email valide.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'password.required' => 'Le champ mot de passe est obligatoire.',
            'password.min' => 'Le mot de passe doit avoir au moins :min caractères.',
            'password_confirmation.required' => 'Le champ confirmation de mot de passe est obligatoire.',
            'password_confirmation.min' => 'Le confirmation mot de passe doit avoir au moins :min caractères.'
        ];
    }
}
