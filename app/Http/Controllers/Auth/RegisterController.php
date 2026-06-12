<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = '/dashboard';

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * A tela de cadastro pede apenas nome, e-mail e senha.
     * Por isso 'celular' e 'data_nascimento' são OPCIONAIS aqui —
     * o agrônomo completa esses dados depois em "Meu perfil".
     * (Antes eram obrigatórios e a validação falhava sempre, sem
     *  campos no formulário para corrigir — por isso o cadastro não funcionava.)
     */
    protected function validator(array $data)
    {
        if (isset($data['celular'])) {
            $data['celular'] = preg_replace('/\D/', '', $data['celular']);
        }

        return Validator::make($data, [
            'name'            => ['required', 'string', 'max:255'],
            'email'           => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password'        => ['required', 'string', 'min:8', 'confirmed'],
            'data_nascimento' => ['nullable', 'date'],
            'celular'         => ['nullable', 'digits_between:10,15'],
        ], [
            'celular.digits_between' => 'O celular deve conter apenas números e ter entre 10 e 15 dígitos.',
            'email.unique'           => 'Este e-mail já está cadastrado.',
            'password.confirmed'     => 'A confirmação de senha não confere.',
            'password.min'           => 'A senha deve ter no mínimo 8 caracteres.',
        ]);
    }

    protected function create(array $data)
    {
        $celular = null;
        if (!empty($data['celular'])) {
            $numero = preg_replace('/\D/', '', $data['celular']);
            $celular = $this->formatarCelular($numero);
        }

        return User::create([
            'name'            => $data['name'],
            'email'           => $data['email'],
            'password'        => Hash::make($data['password']),
            'data_nascimento' => $data['data_nascimento'] ?? null,
            'celular'         => $celular,
        ]);
    }

    private function formatarCelular(string $numero): string
    {
        if (strlen($numero) === 11) {
            return preg_replace('/(\d{2})(\d{5})(\d{4})/', '($1) $2-$3', $numero);
        } elseif (strlen($numero) === 10) {
            return preg_replace('/(\d{2})(\d{4})(\d{4})/', '($1) $2-$3', $numero);
        }
        return $numero;
    }
}
