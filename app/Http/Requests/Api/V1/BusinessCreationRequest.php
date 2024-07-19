<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class BusinessCreationRequest extends FormRequest
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
            'name' => ['string', 'required'],
            'short_name' => ['string', 'required', 'unique:businesses,short_name'],
            'phone' => ['digits:11', 'required'],
            'email' => ['email', 'required', 'unique:businesses,email'],
            'address' => ['string', 'required'],
            'country' => ['string', 'required'],
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