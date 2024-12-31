<?php

namespace App\Http\Requests;

use App\Helper\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class UserRequest extends FormRequest
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
            'name'      =>  'required|max:255|string',
            'email'     =>  'email|required|unique:users|max:255',
            'password'  =>  ['required', Rules\Password::default(), 'confirmed']
        ];
    }




    function failedValidation(validator $validator)
    {
        if ($this->is('api/*')) {
            $response = ApiResponse::send_response(422, 'Validation error', $validator->messages()->all());
            throw new ValidationException($validator, $response);
        }
    }
}
