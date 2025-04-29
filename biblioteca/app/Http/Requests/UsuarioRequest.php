<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UsuarioRequest extends FormRequest
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
        $rules = [
            'nome' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
            ]
        ];
        
        // Se for atualização (PUT/PATCH), adiciona a regra para email único ignorando o próprio registro
        if (in_array($this->method(), ['PUT', 'PATCH'])) {
            $rules['email'][] = Rule::unique('usuarios')->ignore($this->usuario);
        } else {
            // Se for criação (POST), adiciona a regra para email único
            $rules['email'][] = 'unique:usuarios';
        }
        
        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'nome.required' => 'O nome do usuário é obrigatório',
            'email.required' => 'O e-mail do usuário é obrigatório',
            'email.email' => 'O e-mail informado não é válido',
            'email.unique' => 'Este e-mail já está sendo utilizado por outro usuário',
        ];
    }
}