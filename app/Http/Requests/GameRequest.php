<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GameRequest extends FormRequest
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
			'name' => 'required|min:3|max:256',
			'studio_id' => 'required|integer|exists:studios,id',
			'genre_id' => 'required|integer|exists:genres,id',
			'description' => 'nullable|string',
			'price' => 'nullable|numeric',
			'year' => 'nullable|integer',
			'image' => 'nullable|image',
			'display' => 'nullable|boolean',
		];
	}
	public function messages(): array
	{
		return [
			'required' => 'Lauks ":attribute" ir obligāts',
			'min' => 'Laukam ":attribute" jābūt vismaz :min simbolus garam',
			'max' => 'Lauks ":attribute" nedrīkst būt garāks par :max simboliem',
			'boolean' => 'Lauka ":attribute" vērtībai jābūt "true" vai "false"',
			'unique' => 'Šāda lauka ":attribute" vērtība jau ir reģistrēta',
			'numeric' => 'Lauka ":attribute" vērtībai jābūt skaitlim',
			'image' => 'Laukā ":attribute" jāpievieno korekts attēla fails',
			'integer' => 'Lauka ":attribute" vērtībai jābūt veselam skaitlim',
		];
	}

	public function attributes(): array
	{
		return [
			'name' => 'nosaukums',
			'studio_id' => 'studija',
			'genre_id' => 'žanrs',
			'description' => 'apraksts',
			'price' => 'cena',
			'year' => 'gads',
			'image' => 'attēls',
			'display' => 'publicēt',
		];
	}

}
