<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BusinessUpdateRequest extends FormRequest
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
            'image' => ['sometimes', 'mimes:png,jpg,jpeg', 'max:2048'],
            'name' => ['string', 'sometimes'],
            'short_name' => ['string', 'sometimes', 'unique:businesses,short_name'],
            'phone' => ['digits:11', 'sometimes'],
            'email' => ['email', 'sometimes', 'unique:businesses,email'],
            'address' => ['string', 'sometimes'],
            'country' => ['string', 'sometimes'],
            'is_active' => ['boolean', 'sometimes'],
        ];
    }
    
    public function failedValidation (Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation errors',
            'data' => $validator->errors()
        ], 400));
    }

}