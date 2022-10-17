<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminUserRequest extends FormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules()
    {
        $rules = [
            "name" => ['required', 'string', 'min:4', 'max:15'],
            "access_admin" => ['required', 'numeric', 'boolean'],
            "password" => ['required', 'string', 'min:4', 'max:15'],
        ];

        switch ($this->getMethod()) {
            case "POST":
                return $rules;

            case "PUT":
                return [
                    "name" => ['string', 'min:4', 'max:15'],
                    "access_admin" => ['numeric', 'boolean'],
                    "password" => ['string', 'min:4', 'max:15'],
                ];
        }
    }

    public function attributes()
    {
        return [
            'name' => 'Логин',
            'access_admin' => 'доуступ админа',
            'password' => 'Пароль',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Поле `:attribute` не заполнено!',
            'max' => 'Поле `:attribute` не должно быть больше :max символов',
            'min' => 'Поле `:attribute` не должно быть меньше :min символов',
            'string' => 'Проверьте правильность `:attribute`',
            'boolean' => 'Поле `:attribute` должно быть True или false'
        ];
    }
}
