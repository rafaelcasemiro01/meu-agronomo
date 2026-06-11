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

        // --- Saudação e data no fuso do Brasil, em português ---
        $agora = now()->timezone('America/Sao_Paulo');
        $hora  = $agora->hour;
        $saudacao = $hora < 12 ? 'Bom dia' : ($hora < 18 ? 'Boa tarde' : 'Boa noite');
        $dataExtenso = mb_strtoupper(
            str_replace('-feira', '', $agora->locale('pt_BR')->isoFormat('dddd · D MMM YYYY'))
        );
        $primeiroNome = explode(' ', trim($user->name))[0];

        // --- Métricas do painel ---
        $totalClientes  = $user->clientes()->count();
        $clientesAtivos = $user->clientes()->where('status', true)->count();
        $novosMes       = $user->clientes()
                            ->whereMonth('created_at', $agora->month)
                            ->whereYear('created_at', $agora->year)
                            ->count();

        $visitasAgendadas = $user->visitas()
                            ->where('status', 'agendada')
                            ->whereBetween('data_visita', [
                                $agora->copy()->startOfDay(),
                                $agora->copy()->addDays(7)->endOfDay(),
                            ])
                            ->count();

        // Visitas para amanhã (para o aviso do topo)
        $visitasAmanha = $user->visitas()
                            ->where('status', 'agendada')
                            ->whereDate('data_visita', $agora->copy()->addDay()->toDateString())
                            ->count();

        // --- Relatórios ---
        $totalRelatorios     = $user->relatorios()->count();
        $relatoriosRascunho  = $user->relatorios()->where('status', 'rascunho')->count();

        // --- Área total acompanhada (soma de hectares dos clientes ativos) ---
        $areaTotal = (float) $user->clientes()->where('status', true)->sum('area_total_ha');

        // --- Aviso dinâmico abaixo da saudação ---
        $partes = [];
        if ($visitasAmanha > 0) {
            $partes[] = '<b>' . $visitasAmanha . ' visita' . ($visitasAmanha > 1 ? 's' : '') . ' amanhã</b>';
        } elseif ($visitasAgendadas > 0) {
            $partes[] = '<b>' . $visitasAgendadas . ' visita' . ($visitasAgendadas > 1 ? 's' : '') . '</b> nos próximos 7 dias';
        }
        if ($relatoriosRascunho > 0) {
            $partes[] = '<b>' . $relatoriosRascunho . ' relatório' . ($relatoriosRascunho > 1 ? 's' : '') . '</b> em rascunho';
        }

        if (count($partes) > 0) {
            $aviso = 'Você tem ' . implode(' e ', $partes) . '.';
        } else {
            $aviso = 'Tudo em ordem por aqui — nenhuma pendência.';
        }

        // --- Próximas visitas (agendadas, a partir de hoje) ---
        $proximasVisitas = $user->visitas()
                            ->with('cliente')
                            ->where('status', 'agendada')
                            ->whereDate('data_visita', '>=', $agora->toDateString())
                            ->orderBy('data_visita')
                            ->orderBy('hora_visita')
                            ->take(4)
                            ->get();

        // --- Clientes recentes ---
        $clientes = $user->clientes()->where('status', true)->latest()->take(5)->get();

        return view('home', compact(
            'saudacao', 'dataExtenso', 'primeiroNome', 'aviso',
            'totalClientes', 'clientesAtivos', 'novosMes', 'areaTotal',
            'visitasAgendadas', 'visitasAmanha',
            'totalRelatorios', 'relatoriosRascunho',
            'proximasVisitas', 'clientes'
        ));
    }
}
