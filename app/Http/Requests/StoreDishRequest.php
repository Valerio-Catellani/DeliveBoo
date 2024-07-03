<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDishRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0', 'max:9999.99'],
            'image' => ['nullable', 'image'],
            'ingredients' => ['required', 'string'],
            'visible' => ['boolean'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Inserisci il nome del piatto',
            'description.string' => 'La descrizione deve essere una stringa',
            'price.required' => 'Inserisci il prezzo del piatto',
            'price.numeric' => 'Il prezzo deve essere un numero',
            'price.min' => 'Il prezzo deve essere superiore a 0',
            'price.max' => 'Il prezzo deve essere inferiore a 9999.99',
            'image.image' => 'L\'immagine deve essere un file immagine',
            'visible.boolean' => 'Il campo visibile deve essere vero o falso',
            'ingredients.required' => 'Inserisci gli ingredienti del piatto',
            'ingredients.string' => 'Gli ingredienti devono essere una stringa',
        ];
    }
}
