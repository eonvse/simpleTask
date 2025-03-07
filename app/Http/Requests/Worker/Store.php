<?php

namespace App\Http\Requests\Worker;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class Store extends FormRequest
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
                'name' => ['required','min:4'],
                'email' => ['required','email'],
                'status' => [
                    'required',
                    Rule::in(['Работает','В отпуске'])
                    ]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Поле name обязательно для заполнения.',
            'name.min' => 'Поле name должно быть не менее 4 символов.',
            'email.required' => 'Поле email обязательно для заполнения.',
            'email.email' => 'Поле email должно быть действительным email-адресом.',
            'email.unique' => 'Такой email уже зарегистрирован.',
            'status.required' => 'Поле status обязательно для заполнения.',
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
