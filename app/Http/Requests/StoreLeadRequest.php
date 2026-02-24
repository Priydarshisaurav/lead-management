<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLeadRequest extends FormRequest
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
   public function rules()
{
    return [
        'name'=>'required',
        'company_name'=>'required',
        'email'=>'required|email',
        'phone'=>'required',
        'source'=>'required|in:Instagram,Website,Reference,Cold Call',
        'assigned_to'=>'nullable|exists:users,id',
        'expected_value'=>'nullable|numeric'
    ];
}

}
