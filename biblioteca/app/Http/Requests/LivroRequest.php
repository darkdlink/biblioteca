<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LivroRequest extends FormRequest
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
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'ano' => 'required|integer|min:1000|max:' . date('Y'),
            'categoria' => 'required|string|max:100',
            'disponivel' => 'sometimes|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'titulo.required' => 'O título do livro é obrigatório',
            'autor.required' => 'O autor do livro é obrigatório',
            'ano.required' => 'O ano de publicação é obrigatório',
            'ano.integer' => 'O ano deve ser um número inteiro',
            'ano.min' => 'O ano de publicação deve ser maior ou igual a 1000',
            'ano.max' => 'O ano de publicação não pode ser maior que o ano atual',
            'categoria.required' => 'A categoria do livro é obrigatória',
        ];
    }
}
