<?php
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'cep' => 'required|string|size:8',
            'rua' => 'required|string|max:255',
            'bairro' => 'required|string|max:255',
            'numero' => 'nullable|string|max:10',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|size:2',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'email.required' => 'O e-mail é obrigatório.',
            'email.unique' => 'Opa, esse e-mail já está sendo utilizado.',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha precisa ter no mínimo 8 caracteres.',
            'cep.required' => 'O CEP é obrigatório.',
            'cep.size' => 'O CEP deve ter exatamente 8 caracteres.',
            'rua.required' => 'O nome da rua precisa ser informado',
            'bairro.required' => 'O nome do bairro precisa ser informado',
            'cidade.required' => 'O nome da cidade precisa ser informado',
            'estado.required' => 'O estado precisa ser informado',
        ];
    }
}
