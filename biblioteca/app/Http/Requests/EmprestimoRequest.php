<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmprestimoRequest extends FormRequest
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
            'usuario_id' => 'required|exists:usuarios,id',
            'livro_id' => 'required|exists:livros,id',
            'data_emprestimo' => 'sometimes|date|before_or_equal:today',
            'data_prevista_devolucao' => 'sometimes|date|after_or_equal:data_emprestimo',
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
            'usuario_id.required' => 'É necessário selecionar um usuário',
            'usuario_id.exists' => 'O usuário selecionado não existe',
            'livro_id.required' => 'É necessário selecionar um livro',
            'livro_id.exists' => 'O livro selecionado não existe',
            'data_emprestimo.date' => 'A data de empréstimo deve ser uma data válida',
            'data_emprestimo.before_or_equal' => 'A data de empréstimo não pode ser no futuro',
            'data_prevista_devolucao.date' => 'A data prevista de devolução deve ser uma data válida',
            'data_prevista_devolucao.after_or_equal' => 'A data prevista de devolução deve ser igual ou posterior à data de empréstimo',
        ];
    }
}