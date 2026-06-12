<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        if (config('app.env') === 'production') {
            \URL::forceScheme('https');
        }

        // Paginação no padrão estilizado pelo style.css (Bootstrap CSS foi removido)
        Paginator::useBootstrapFive();

        /*
        |--------------------------------------------------------------------
        | NOTIFICAÇÕES (sino da topbar)
        |--------------------------------------------------------------------
        | Calcula, a cada carregamento do layout, as visitas agendadas que
        | merecem aviso:
        |   • visitas de AMANHÃ (1 dia de antecedência)
        |   • visitas de HOJE que estão chegando perto da hora (≤ 3h)
        | Sem precisar de cron/fila — é calculado on-the-fly e exibido no sino.
        */
        View::composer('dashboard', function ($view) {
            $notificacoes = collect();

            if (Auth::check()) {
                /** @var \App\Models\User $user */
                $user  = Auth::user();
                $agora = Carbon::now('America/Sao_Paulo');

                $visitas = $user->visitas()
                    ->with('cliente')
                    ->where('status', 'agendada')
                    ->whereDate('data_visita', '>=', $agora->copy()->toDateString())
                    ->whereDate('data_visita', '<=', $agora->copy()->addDay()->toDateString())
                    ->orderBy('data_visita')
                    ->orderBy('hora_visita')
                    ->get();

                foreach ($visitas as $v) {
                    $hora = $v->hora_visita ? substr($v->hora_visita, 0, 5) : '00:00';

                    // Monta o momento exato da visita
                    try {
                        $quando = Carbon::parse(
                            $v->data_visita->format('Y-m-d') . ' ' . $hora,
                            'America/Sao_Paulo'
                        );
                    } catch (\Throwable $e) {
                        $quando = $v->data_visita;
                    }

                    $cliente = optional($v->cliente)->nome ?? 'Cliente';
                    $ehHoje  = $v->data_visita->isSameDay($agora);

                    if ($ehHoje) {
                        $horasAte = $agora->diffInHours($quando, false);
                        if ($horasAte < 0) {
                            continue; // já passou
                        }
                        $urgente = $horasAte <= 3;
                        $texto   = $urgente
                            ? 'Começa em breve — hoje às ' . $hora
                            : 'Hoje às ' . $hora;
                    } else {
                        $urgente = false;
                        $texto   = 'Amanhã às ' . $hora;
                    }

                    $notificacoes->push((object) [
                        'cliente' => $cliente,
                        'texto'   => $texto,
                        'urgente' => $urgente,
                        'hora'    => $hora,
                    ]);
                }

                // urgentes primeiro
                $notificacoes = $notificacoes->sortByDesc('urgente')->values();
            }

            $view->with('notificacoes', $notificacoes);
        });
    }
}
