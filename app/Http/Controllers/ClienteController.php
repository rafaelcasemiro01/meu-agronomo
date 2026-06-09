<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User; // <-- Importar o modelo User para o DocBlock

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mostra uma lista de todos os clientes DO USUÁRIO LOGADO, com opção de pesquisa e filtro de status.
     */
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */ // <-- DocBlock para Intelephense
        $user = Auth::user();

        $query = $user->clientes(); // ESSENCIAL: Filtra por user_id do agrônomo logado

        $status = $request->input('status', 'ativo');

        if ($status === 'ativo') {
            $query->where('status', true);
        } elseif ($status === 'inativo') {
            $query->where('status', false);
        }

        if ($request->has('search') && !empty($request->search)) {
            $searchTerm = $request->search;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nome', 'like', '%' . $searchTerm . '%')
                  ->orWhere('cpf', 'like', '%' . $searchTerm . '%')
                  // NOVO: Adicionado para pesquisa na propriedade também
                  ->orWhere('nome_propriedade', 'like', '%' . $searchTerm . '%')
                  ->orWhere('cidade', 'like', '%' . $searchTerm . '%')
                  ->orWhere('contato', 'like', '%' . $searchTerm . '%');
            });
        }

        $clientes = $query->latest()->paginate(10); // Adicionado paginate para melhor UX

        return view('clientes.index', compact('clientes', 'status'));
    }

    /**
     * Mostra o formulário para criar um novo cliente.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Guarda um novo cliente na base de dados, associando-o ao usuário logado, com informações completas da propriedade.
     */
    public function store(Request $request)
    {
        /** @var \App\Models\User $user */ // <-- DocBlock para Intelephense
        $user = Auth::user();

        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:clientes,cpf,NULL,id,user_id,' . $user->id,
            'rg' => 'nullable|string|max:20',
            'telefone' => 'nullable|string|max:20',
            'contato' => 'required|string|max:15',
            'endereco' => 'required|string|max:255', // Endereço é importante para visita
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:50',
            'cep' => 'required|string|max:10',
            // --- NOVAS VALIDAÇÕES PARA OS DADOS DA PROPRIEDADE ---
            'nome_propriedade' => 'required|string|max:255',
            'area_total_ha' => 'required|numeric|min:0.01',   // Área em hectares (mínimo 0.01)
            'cultura_principal' => 'nullable|string|max:100', // Campo opcional
            // --- FIM DAS NOVAS VALIDAÇÕES ---
        ]);

        $user->clientes()->create($validatedData);

        return redirect()->route('clientes.index')->with('success', 'Cliente e propriedade adicionados com sucesso!');
    }

    /**
     * Exibe os detalhes de um cliente específico DO USUÁRIO LOGADO.
     * Usa Route Model Binding.
     */
    public function show(Cliente $cliente)
    {
        /** @var \App\Models\User $user */ // <-- DocBlock para Intelephense
        $user = Auth::user();

        if ($cliente->user_id !== $user->id) {
            abort(403, 'Acesso não autorizado a este cliente.');
        }
        return view('clientes.show', compact('cliente'));
    }

    /**
     * Mostra o formulário para editar um cliente existente DO USUÁRIO LOGADO.
     * Usa Route Model Binding.
     */
    public function edit(Cliente $cliente)
    {
        /** @var \App\Models\User $user */ // <-- DocBlock para Intelephense
        $user = Auth::user();

        if ($cliente->user_id !== $user->id) {
            abort(403, 'Acesso não autorizado a este cliente.');
        }
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Atualiza um cliente existente DO USUÁRIO LOGADO na base de dados, com informações completas da propriedade.
     */
    public function update(Request $request, Cliente $cliente)
    {
        /** @var \App\Models\User $user */ // <-- DocBlock para Intelephense
        $user = Auth::user();

        if ($cliente->user_id !== $user->id) {
            abort(403, 'Acesso não autorizado a este cliente.');
        }

        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'cpf' => 'required|string|max:14|unique:clientes,cpf,'.$cliente->id.',id,user_id,'.$user->id,
            'rg' => 'nullable|string|max:20',
            'telefone' => 'nullable|string|max:20',
            'contato' => 'required|string|max:15',
            'endereco' => 'required|string|max:255',
            'cidade' => 'required|string|max:255',
            'estado' => 'required|string|max:50',
            'cep' => 'required|string|max:10',
            // --- NOVAS VALIDAÇÕES PARA OS DADOS DA PROPRIEDADE ---
            'nome_propriedade' => 'required|string|max:255',
            'area_total_ha' => 'required|numeric|min:0.01',
            'cultura_principal' => 'nullable|string|max:100',
            // --- FIM DAS NOVAS VALIDAÇÕES ---
        ]);

        $cliente->update($validatedData);

        return redirect()->route('clientes.index')->with('success', 'Cliente e propriedade atualizados com sucesso!');
    }

    /**
     * Inativa um cliente DO USUÁRIO LOGADO na base de dados.
     * Usa Route Model Binding para encontrar o cliente.
     */
    public function destroy(Cliente $cliente)
    {
        /** @var \App\Models\User $user */ // <-- DocBlock para Intelephense
        $user = Auth::user();

        if ($cliente->user_id !== $user->id) {
            abort(403, 'Acesso não autorizado a este cliente.');
        }

        $cliente->update(['status' => false]);

        return redirect()->route('clientes.index')->with('success', 'Cliente inativado com sucesso!');
    }

    /**
     * Reativa um cliente DO USUÁRIO LOGADO na base de dados.
     * Este é um novo método para reativar clientes inativos.
     */
    public function activate(Cliente $cliente)
    {
        /** @var \App\Models\User $user */ // <-- DocBlock para Intelephense
        $user = Auth::user();

        if ($cliente->user_id !== $user->id) {
            abort(403, 'Acesso não autorizado a este cliente.');
        }

        $cliente->update(['status' => true]);
        return redirect()->route('clientes.index')->with('success', 'Cliente reativado com sucesso!');
    }
}
