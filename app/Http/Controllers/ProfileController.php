<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Auth; // <-- Adicione esta linha

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function editInfo()
    {
        // Use a facade Auth::user()
        /** @var \App\Models\User $user */
        $user = Auth::user(); // <-- Alterado aqui

        return view('profile.edit-info', [
            'user' => $user,
        ]);
    }

    public function updateInfo(Request $request)
    {
        // Use a facade Auth::user()
        /** @var \App\Models\User $user */
        $user = Auth::user(); // <-- Alterado aqui

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
             'celular' => ['nullable', 'string', 'max:20'], // Validação para celular
            'data_nascimento' => ['nullable', 'date'], // Validação para data de nascimento
        ]);

        $user->fill($request->only('name', 'email', 'celular', 'data_nascimento'));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()->route('perfil.info')->with('success', 'Informações de perfil atualizadas com sucesso!');
    }

    public function editPassword()
    {
        return view('profile.edit-password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', Rules\Password::defaults(), 'confirmed'],
        ]);

        // Use a facade Auth::user()
        /** @var \App\Models\User $user */
        $user = Auth::user(); // <-- Alterado aqui

        if (! Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => __('A senha atual fornecida está incorreta.'),
            ]);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('perfil.senha')->with('success', 'Senha atualizada com sucesso!');
    }
}
