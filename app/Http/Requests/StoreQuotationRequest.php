<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuotationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Authorization is handled in the controller
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
{
    return [
        'lead_id'=>'required|exists:leads,id',
        'product_name'=>'required',
        'quantity'=>'required|integer|min:1',
        'rate'=>'required|numeric|min:0',
        'gst_percentage'=>'required|in:5,12,18,28',
        'valid_till'=>'required|date|after:today'
    ];
}

}
