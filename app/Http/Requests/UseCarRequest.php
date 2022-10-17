<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UseCarRequest extends FormRequest
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
        return [
            "car_id" => ['required', 'numeric', Rule::exists('cars', 'id')],
            "user_id" => ['required', 'numeric', Rule::exists('users', 'id')],
        ];
    }

    public function attributes()
    {
        return [
            'car_id' => 'Идентификатор автомобилья',
            'user_id' => 'Идентификатор пользователя',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Поле `:attribute` не заполнено!',
            'max' => 'Поле `:attribute` не должно быть больше :max символов',
            'min' => 'Поле `:attribute` не должно быть меньше :min символов',
            'string' => 'Проверьте правильность `:attribute`',
            'exists' => '`:attribute` Не существует'
        ];
    }
}
