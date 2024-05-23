<?php

namespace App\Http\Requests;

use App\Models\SsDetail;
use Illuminate\Foundation\Http\FormRequest;

class UpdateSsDetailRequest extends FormRequest
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
        $rules = SsDetail::$rules;
        
        return $rules;
    }
}
