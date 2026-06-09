<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\VisitaTecnica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Garanta que esta linha esteja aqui

class VisitaTecnicaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mostra o formulário para agendar uma nova visita técnica.
     */
    public function create()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // O relacionamento 'clientes' no modelo User já deve existir.
        $clientes = $user->clientes()->orderBy('nome')->get(['id', 'nome', 'nome_propriedade', 'endereco', 'cidade', 'estado']);

        return view('visitas.agendar', compact('clientes'));
    }

    /**
     * Guarda uma nova visita técnica na base de dados.
     */
    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validatedData = $request->validate([
            'cliente_id' => 'required|exists:clientes,id,user_id,'.$user->id,
            'data_visita' => 'required|date|after_or_equal:today',
            'hora_visita' => 'required|date_format:H:i',
            'local_visita' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string',
        ]);

        // Cria a visita através do relacionamento do usuário
        $visita = $user->visitas()->create([
            'cliente_id' => $validatedData['cliente_id'],
            'data_visita' => $validatedData['data_visita'],
            'hora_visita' => $validatedData['hora_visita'],
            'local_visita' => $validatedData['local_visita'] ?? null,
            'observacoes' => $validatedData['observacoes'] ?? null,
            'status' => 'agendada', // Definindo um status padrão
        ]);

        return redirect()->route('visitas.minhas')->with('success', 'Visita técnica agendada com sucesso!');
    }

    /**
     * Lista as visitas do usuário logado, com opção de filtro por status.
     */
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

    /**
     * Cancela uma visita técnica específica.
     *
     * @param \App\Models\VisitaTecnica $visita
     * @return \Illuminate\Http\RedirectResponse
     */
    public function cancelar(VisitaTecnica $visita)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        if ($visita->user_id !== $user->id) {
            return redirect()->route('visitas.minhas')->with('error', 'Você não tem permissão para cancelar esta visita.');
        }

        if ($visita->status !== 'agendada') {
            return redirect()->route('visitas.minhas')->with('error', 'A visita não pode ser cancelada pois não está no status "agendada".');
        }

        $visita->status = 'cancelada';
        $visita->save();

        return redirect()->route('visitas.minhas')->with('success', 'Visita técnica cancelada com sucesso!');
    }

    /**
     * Confirma a realização de uma visita técnica específica.
     *
     * @param \App\Models\VisitaTecnica $visita
     * @return \Illuminate\Http\RedirectResponse
     */
    public function realizar(VisitaTecnica $visita)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        // 1. Verificação de Autorização: A visita pertence ao usuário logado?
        if ($visita->user_id !== $user->id) {
            return redirect()->route('visitas.minhas')->with('error', 'Você não tem permissão para confirmar esta visita.');
        }

        // 2. Verificação de Status: A visita pode ser confirmada como realizada?
        // Só pode ser realizada se estiver 'agendada'.
        if ($visita->status !== 'agendada') {
            return redirect()->route('visitas.minhas')->with('error', 'A visita não pode ser confirmada como realizada pois não está no status "agendada".');
        }

        // 3. Atualiza o status para 'realizada'
        $visita->status = 'realizada';
        $visita->save();

        // 4. Redireciona com mensagem de sucesso
        return redirect()->route('visitas.minhas')->with('success', 'Visita técnica confirmada como realizada!');
    }
}
