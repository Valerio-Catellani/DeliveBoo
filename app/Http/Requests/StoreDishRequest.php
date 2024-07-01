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
            'description' => ['required'],
            'price' => ['required', 'numeric', 'min:0', 'max:9999.99'],
            'image' => ['image'],
            'ingredients' => ['required'],
            'visible' => ['boolean'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Inserisci il nome del piatto',
            'description.required' => 'Inserisci la descrizione del piatto',
            'price.required' => 'Inserisci il prezzo del piatto',
            'image.image' => 'L\'immagine deve essere un file immagine',
            'price.numeric' => 'Il prezzo deve essere un numero',
            'price.min' => 'Il prezzo deve essere superiore a 0',
            'price.max' => 'Il prezzo deve essere inferiore a 9999.99',
            'visible.required' => 'Seleziona se il piatto deve essere visibile o meno',
            'ingredients.required' => 'Inserisci gli ingredienti del piatto',
        ];
    }
}
