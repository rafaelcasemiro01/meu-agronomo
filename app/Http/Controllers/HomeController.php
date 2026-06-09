<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\Auth; // <-- IMPORTANTE: Importar Auth
use App\Models\User; // <-- IMPORTANTE: Importar o modelo User para o DocBlock

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        /** @var \App\Models\User $user */ // <-- Adiciona o DocBlock para o Intelephense
        $user = Auth::user(); // Obtém o usuário logado

        // 2. Busca os 5 clientes mais recentes do USUÁRIO LOGADO, filtrando por 'status' = 1 (ativo)
        $clientes = $user->clientes()->where('status', 1)->latest()->take(5)->get();

        // 3. Envia a variável $clientes para a view 'home' (anteriormente era 'dashboard')
        // AGORA RETORNAMOS A NOVA VIEW 'home' que contém o conteúdo do dashboard.
        // A view 'dashboard.blade.php' agora é o nosso layout base.
        return view('home', compact('clientes'));
    }
}
