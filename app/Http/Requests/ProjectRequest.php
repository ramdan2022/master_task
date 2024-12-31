<?php

namespace App\Http\Requests;

use App\Helper\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Validation\Validator;

class ProjectRequest extends FormRequest
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
            'Name'          => 'required',
            'Descreption'   => 'required',
            'Email'         => 'required|email'

        ];
    }






    function failedValidation(Validator $validator)
    {
        if ($this->is('api/*')) {
            $response =  ApiResponse::send_response(
                422,
                'user name is required and des',

                $validator->messages()->all()
            );
            // display validator errors
            throw new ValidationException($validator, $response);
        }
    }
}
