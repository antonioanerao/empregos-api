<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

/**
 * @property string $title
 * @property string $description
 * @property string $expirationDate
 * @property string $email
 * @property string $phone
 * @property string $companyName
 */
class JobRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required',
            'description' => 'required',
            'expirationDate' => 'required|date_format:d/m/Y',
            'email' => 'required_without:phone|email',
            'phone' => 'required_without:email',
            'companysName' => 'nullable|string'
        ];
    }

    public function messages(): array
    {
        return [
            'expirationDate.date_format' => 'The expiration date does not match the format dd/mm/yyyy.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], 422));
    }
}
