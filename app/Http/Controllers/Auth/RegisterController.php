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

    protected function validator(array $data)
    {
        // Remove tudo que não for número do celular antes da validação
        if (isset($data['celular'])) {
            $data['celular'] = preg_replace('/\D/', '', $data['celular']);
        }

        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'data_nascimento' => ['required', 'date'],
            'celular' => ['required', 'digits_between:10,15'],
        ], [
            'celular.digits_between' => 'O celular deve conter apenas números e ter entre 10 e 15 dígitos.',
            'email.unique' => 'Usuário já cadastrado!',
        ]);
    }

    protected function create(array $data)
    {
        // Remove caracteres não numéricos do celular
        $numero = preg_replace('/\D/', '', $data['celular']);

        // Formata o celular para exibição
        $celular = $this->formatarCelular($numero);

        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'data_nascimento' => $data['data_nascimento'],
            'celular' => $celular,
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
