<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function editInfo()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        return view('perfil.info', [
            'user' => $user,
        ]);
    }

    public function updateInfo(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name'            => ['required', 'string', 'max:255'],
            'email'           => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'celular'         => ['nullable', 'string', 'max:20'],
            'data_nascimento' => ['nullable', 'date'],
            'crea'            => ['nullable', 'string', 'max:30'], // Registro profissional
        ]);

        $user->fill($request->only('name', 'email', 'celular', 'data_nascimento', 'crea'));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()->route('perfil.info')->with('success', 'Informações de perfil atualizadas com sucesso!');
    }

    public function editPassword()
    {
        return view('perfil.senha');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password'         => ['required', Rules\Password::defaults(), 'confirmed'],
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

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
