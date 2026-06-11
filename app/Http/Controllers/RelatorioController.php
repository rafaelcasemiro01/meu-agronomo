<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Relatorio;
use App\Models\VisitaTecnica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RelatorioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Lista os relatórios do usuário logado, com filtro por status e busca.
     */
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $query = $user->relatorios()->with('cliente');

        $status = $request->input('status', 'todos');
        if (in_array($status, ['rascunho', 'finalizado'])) {
            $query->where('status', $status);
        }

        if ($request->filled('search')) {
            $termo = $request->search;
            $query->where(function ($q) use ($termo) {
                $q->where('titulo', 'like', "%{$termo}%")
                  ->orWhere('tipo', 'like', "%{$termo}%")
                  ->orWhereHas('cliente', function ($c) use ($termo) {
                      $c->where('nome', 'like', "%{$termo}%")
                        ->orWhere('nome_propriedade', 'like', "%{$termo}%");
                  });
            });
        }

        $relatorios = $query->latest('data_relatorio')->latest()->paginate(10);

        return view('relatorios.index', compact('relatorios', 'status'));
    }

    /**
     * Formulário de criação. Aceita ?visita={id} para pré-preencher a partir
     * de uma visita técnica realizada.
     */
    public function create(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $clientes = $user->clientes()->where('status', true)->orderBy('nome')->get();

        // Visitas realizadas que ainda podem virar relatório (para o seletor)
        $visitas = $user->visitas()->with('cliente')
                    ->where('status', 'realizada')
                    ->latest('data_visita')
                    ->get();

        $visitaSelecionada = null;
        if ($request->filled('visita')) {
            $visitaSelecionada = $user->visitas()->with('cliente')->find($request->visita);
        }

        return view('relatorios.create', compact('clientes', 'visitas', 'visitaSelecionada'));
    }

    /**
     * Salva um novo relatório.
     */
    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $dados = $request->validate([
            'cliente_id'        => 'required|exists:clientes,id,user_id,'.$user->id,
            'visita_tecnica_id' => 'nullable|exists:visitas_tecnicas,id,user_id,'.$user->id,
            'titulo'            => 'required|string|max:255',
            'tipo'              => 'required|string|max:100',
            'data_relatorio'    => 'required|date',
            'diagnostico'       => 'nullable|string',
            'recomendacoes'     => 'nullable|string',
            'status'            => 'nullable|in:rascunho,finalizado',
        ]);

        $dados['status'] = $dados['status'] ?? 'rascunho';

        $user->relatorios()->create($dados);

        return redirect()->route('relatorios.index')->with('success', 'Relatório criado com sucesso!');
    }

    /**
     * Exibe um relatório.
     */
    public function show(Relatorio $relatorio)
    {
        $this->autorizar($relatorio);
        $relatorio->load('cliente', 'visitaTecnica');

        return view('relatorios.show', compact('relatorio'));
    }

    /**
     * Formulário de edição.
     */
    public function edit(Relatorio $relatorio)
    {
        $this->autorizar($relatorio);

        /** @var \App\Models\User $user */
        $user = Auth::user();
        $clientes = $user->clientes()->orderBy('nome')->get();
        $visitas  = $user->visitas()->with('cliente')->where('status', 'realizada')->latest('data_visita')->get();

        return view('relatorios.edit', compact('relatorio', 'clientes', 'visitas'));
    }

    /**
     * Atualiza um relatório.
     */
    public function update(Request $request, Relatorio $relatorio)
    {
        $this->autorizar($relatorio);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $dados = $request->validate([
            'cliente_id'        => 'required|exists:clientes,id,user_id,'.$user->id,
            'visita_tecnica_id' => 'nullable|exists:visitas_tecnicas,id,user_id,'.$user->id,
            'titulo'            => 'required|string|max:255',
            'tipo'              => 'required|string|max:100',
            'data_relatorio'    => 'required|date',
            'diagnostico'       => 'nullable|string',
            'recomendacoes'     => 'nullable|string',
            'status'            => 'nullable|in:rascunho,finalizado',
        ]);

        $relatorio->update($dados);

        return redirect()->route('relatorios.show', $relatorio)->with('success', 'Relatório atualizado.');
    }

    /**
     * Remove um relatório.
     */
    public function destroy(Relatorio $relatorio)
    {
        $this->autorizar($relatorio);
        $relatorio->delete();

        return redirect()->route('relatorios.index')->with('success', 'Relatório removido.');
    }

    /**
     * Marca um relatório como finalizado.
     */
    public function finalizar(Relatorio $relatorio)
    {
        $this->autorizar($relatorio);

        if ($relatorio->status === 'finalizado') {
            return back()->with('error', 'Este relatório já está finalizado.');
        }

        $relatorio->update(['status' => 'finalizado']);

        return back()->with('success', 'Relatório finalizado com sucesso!');
    }

    /**
     * Garante que o relatório pertence ao usuário logado.
     */
    private function autorizar(Relatorio $relatorio): void
    {
        if ($relatorio->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado a este relatório.');
        }
    }
}
