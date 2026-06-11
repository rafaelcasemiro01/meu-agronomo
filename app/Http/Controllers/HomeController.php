<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // --- Métricas do painel ---
        $totalClientes  = $user->clientes()->count();
        $clientesAtivos = $user->clientes()->where('status', true)->count();
        $novosMes       = $user->clientes()
                            ->whereMonth('created_at', now()->month)
                            ->whereYear('created_at', now()->year)
                            ->count();

        $visitasAgendadas = $user->visitas()
                            ->where('status', 'agendada')
                            ->whereBetween('data_visita', [now()->startOfDay(), now()->addDays(7)->endOfDay()])
                            ->count();

        // --- Próximas visitas (agendadas, a partir de hoje) ---
        $proximasVisitas = $user->visitas()
                            ->with('cliente')
                            ->where('status', 'agendada')
                            ->whereDate('data_visita', '>=', now()->toDateString())
                            ->orderBy('data_visita')
                            ->orderBy('hora_visita')
                            ->take(4)
                            ->get();

        // --- Clientes recentes (para "Atividade recente") ---
        $clientes = $user->clientes()->where('status', true)->latest()->take(5)->get();

        return view('home', compact(
            'totalClientes', 'clientesAtivos', 'novosMes',
            'visitasAgendadas', 'proximasVisitas', 'clientes'
        ));
    }
}
