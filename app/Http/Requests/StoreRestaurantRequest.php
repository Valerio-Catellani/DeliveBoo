<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRestaurantRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'address' => 'required|string|min:3|max:255',
            'VAT' => 'required|unique:restaurants|string|size:11',
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'Il nome è obbligatorio',
            'name.min' => 'Il nome deve avere almeno 3 caratteri',
            'name.max' => 'Il nome deve avere massimo 255 caratteri',
            'address.required' => 'L\'indirizzo è obbligatorio',
            'address.min' => 'L\'indirizzo deve avere almeno 3 caratteri',
            'address.max' => 'L\'indirizzo deve avere massimo 255 caratteri',
            'VAT.required' => 'Il codice fiscale è obbligatorio',
            'VAT.unique' => 'Il codice fiscale inserito deve essere univoco!',
            'VAT.size' => 'Il codice fiscale deve avere 11 caratteri',
        ];
    }
}
