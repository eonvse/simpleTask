<?php

namespace App\Http\Requests\Worker;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class Update extends FormRequest
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
            'name' => ['nullable','min:4'],
            'email' => ['nullable','email'],
            'status' => [
                'nullable',
                Rule::in(['Работает','В отпуске'])
                ]
        ];
    }

    public function messages()
    {
        return [
            'name.min' => 'Поле name должно быть не менее 4 символов.',
            'email.email' => 'Поле email должно быть действительным email-адресом.',
            'status.in' => 'Поле status может содержать один из вариантов:Работает, В отпуске',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Ошибки валидации',
            'data'      => $validator->errors()
        ]));
    }
}
