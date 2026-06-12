<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\VisitaTecnica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VisitaTecnicaController extends Controller
{
    /** Quão perto (em minutos) duas visitas precisam estar para gerar aviso de conflito. */
    private const LIMITE_PROXIMIDADE = 60;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function create()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $clientes = $user->clientes()->orderBy('nome')
            ->get(['id', 'nome', 'nome_propriedade', 'endereco', 'cidade', 'estado']);

        return view('visitas.agendar', compact('clientes'));
    }

    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validatedData = $request->validate([
            'cliente_id'   => 'required|exists:clientes,id,user_id,' . $user->id,
            'data_visita'  => 'required|date|after_or_equal:today',
            'hora_visita'  => 'required|date_format:H:i',
            'local_visita' => 'nullable|string|max:255',
            'observacoes'  => 'nullable|string',
        ]);

        // --- VERIFICAÇÃO DE CONFLITO DE HORÁRIO ---
        $novoMin = $this->emMinutos($validatedData['hora_visita']);

        $visitasDoDia = $user->visitas()
            ->where('status', 'agendada')
            ->whereDate('data_visita', $validatedData['data_visita'])
            ->get();

        $menorDiferenca = null;
        foreach ($visitasDoDia as $v) {
            $diff = abs($this->emMinutos(substr($v->hora_visita, 0, 5)) - $novoMin);
            if ($menorDiferenca === null || $diff < $menorDiferenca) {
                $menorDiferenca = $diff;
            }
        }

        // 1) Horário EXATAMENTE igual → bloqueia sempre
        if ($menorDiferenca === 0) {
            return back()->withInput()->withErrors([
                'hora_visita' => 'Você já tem uma visita agendada exatamente nesta data e horário.',
            ]);
        }

        // 2) Muito próximo (< limite) → pede confirmação, a menos que já tenha confirmado
        if ($menorDiferenca !== null
            && $menorDiferenca < self::LIMITE_PROXIMIDADE
            && ! $request->boolean('confirmar_conflito')) {

            return back()->withInput()
                ->with('confirmar_conflito', true)
                ->with('conflito_msg', "Você já tem uma visita agendada a apenas {$menorDiferenca} min deste horário neste dia. Deseja agendar mesmo assim?");
        }

        // --- CRIA A VISITA ---
        $user->visitas()->create([
            'cliente_id'   => $validatedData['cliente_id'],
            'data_visita'  => $validatedData['data_visita'],
            'hora_visita'  => $validatedData['hora_visita'],
            'local_visita' => $validatedData['local_visita'] ?? null,
            'observacoes'  => $validatedData['observacoes'] ?? null,
            'status'       => 'agendada',
        ]);

        return redirect()->route('visitas.minhas')->with('success', 'Visita técnica agendada com sucesso!');
    }

    public function minhasVisitas(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $query = $user->visitas();
        $status = $request->input('status', 'agendada');

        if ($status !== 'todas') {
            $query->where('status', $status);
        }

        $visitas = $query->with('cliente')
            ->latest('data_visita')
            ->latest('hora_visita')
            ->paginate(10);

        return view('visitas.minhas', compact('visitas'));
    }

    public function cancelar(VisitaTecnica $visita)
    {
        $this->autorizar($visita);

        if ($visita->status !== 'agendada') {
            return redirect()->route('visitas.minhas')->with('error', 'A visita não pode ser cancelada pois não está agendada.');
        }

        $visita->update(['status' => 'cancelada']);

        return redirect()->route('visitas.minhas')->with('success', 'Visita técnica cancelada com sucesso!');
    }

    public function realizar(VisitaTecnica $visita)
    {
        $this->autorizar($visita);

        if ($visita->status !== 'agendada') {
            return redirect()->route('visitas.minhas')->with('error', 'A visita não pode ser confirmada pois não está agendada.');
        }

        $visita->update(['status' => 'realizada']);

        return redirect()->route('visitas.minhas')->with('success', 'Visita técnica confirmada como realizada!');
    }

    /**
     * REABRE uma visita (desfaz "realizada"/"cancelada") — volta para "agendada".
     */
    public function reabrir(VisitaTecnica $visita)
    {
        $this->autorizar($visita);

        if ($visita->status === 'agendada') {
            return redirect()->route('visitas.minhas')->with('error', 'Esta visita já está agendada.');
        }

        $visita->update(['status' => 'agendada']);

        return redirect()->route('visitas.minhas', ['status' => 'agendada'])
            ->with('success', 'Visita reaberta — voltou para "agendada".');
    }

    private function emMinutos(string $hora): int
    {
        [$h, $m] = array_pad(explode(':', $hora), 2, 0);
        return ((int) $h) * 60 + (int) $m;
    }

    private function autorizar(VisitaTecnica $visita): void
    {
        if ($visita->user_id !== Auth::id()) {
            abort(403, 'Você não tem permissão para alterar esta visita.');
        }
    }
}
