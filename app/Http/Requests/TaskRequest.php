<?php

namespace App\Http\Requests;

use App\Helper\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class TaskRequest extends FormRequest
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
            'Title'       => 'required',
            'Descreption' => 'required',
            'project_name'  => 'required'

        ];
    }

    function failedValidation(Validator $validator)
    {
        // $validator is instance contains information about the validation errors,
        if ($this->is('api/*')) {
            $response = ApiResponse::send_response(422, 'Validation error', $validator->errors());
            throw new ValidationException($validator, $response);
        }
    }
}
