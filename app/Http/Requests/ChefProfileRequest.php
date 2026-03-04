<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChefProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        // solo chefs pueden crear/editar su perfil
        return $this->user() && $this->user()->usertype === 'chef';
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name'  => 'nullable|string|max:255',
            'specialty'  => 'required|string|max:255',
            'description'=> 'nullable|string',
            'area'       => 'required|in:preparacion,cocinar,servir,almacenamiento,lavar,pedidos',
            'image'      => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }
}
