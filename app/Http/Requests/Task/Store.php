<?php

namespace App\Http\Requests\Task;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
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
                'description' => ['required','min:4'],
                'status' => [
                    'required',
                    Rule::in(['К выполнению','В работе','Выполнена'])
                    ]
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Поле name обязательно для заполнения.',
            'name.min' => 'Поле name должно быть не менее 4 символов.',
            'description.required' => 'Поле description обязательно для заполнения.',
            'description.min' => 'Поле description должно быть не менее 4 символов.',
            'status.required' => 'Поле status обязательно для заполнения.',
            'status.in' => 'Поле status может содержать один из вариантов:К выполнению, В работе, Выполнена',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Ошибки валидации',
            'data'      => $validator->errors()
        ],422));
    }
}
