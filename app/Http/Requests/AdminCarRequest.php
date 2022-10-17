<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminCarRequest extends FormRequest
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
            "mark" => ['required', 'string', 'min:4', 'max:15'],
            "model" => ['required', 'string', 'min:4', 'max:15'],
            "year" => ['required', 'integer', 'min:4', 'max:4'],
        ];

        switch ($this->getMethod()) {
            case "POST":
                return $rules;

            case "PUT":
                return [
                    "mark" => ['string', 'min:4', 'max:15'],
                    "model" => ['string', 'min:4', 'max:15'],
                    "year" => ['string', 'min:4', 'max:4'],
                ];
        }


    }

    public function attributes()
    {
        return [
            'mark' => 'Марка автомобиля',
            'model' => 'Модель автомобиля',
            'year' => 'Год автомобиля',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'Поле `:attribute` не заполнено!',
            'max' => 'Поле `:attribute` не должно быть больше :max символов',
            'min' => 'Поле `:attribute` не должно быть меньше :min символов',
            'string' => 'Проверьте правильность `:attribute`',
        ];
    }
}
