<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class JobRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'user_id' => 'required', 'title' => 'required', 'description' => 'required',
            'expirationDate' => 'required|date_format:d/m/Y', 'email' => 'required_without:phone|email',
            'phone' => 'required_without:email'
        ];
    }

    public function messages()
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
