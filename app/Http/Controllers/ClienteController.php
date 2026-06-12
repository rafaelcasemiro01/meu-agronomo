<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Lista os clientes do usuário logado, com busca e filtro de status.
     */
    public function index(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $query = $user->clientes();

        $temBusca   = $request->filled('search');
        $searchTerm = trim((string) $request->input('search'));

        // Filtro de status: 'ativo' por padrão.
        // IMPORTANTE: quando há uma busca, procuramos em TODOS os status
        // (a menos que o usuário escolha um filtro explicitamente) — assim
        // o cliente procurado sempre aparece, mesmo se estiver inativo.
        $status = $request->input('status', $temBusca ? 'todos' : 'ativo');

        if ($status === 'ativo') {
            $query->where('status', true);
        } elseif ($status === 'inativo') {
            $query->where('status', false);
        }
        // 'todos' → sem filtro de status

        if ($temBusca && $searchTerm !== '') {
            $query->where(function ($q) use ($searchTerm) {
                $q->where('nome', 'like', '%' . $searchTerm . '%')
                  ->orWhere('cpf', 'like', '%' . $searchTerm . '%')
                  ->orWhere('nome_propriedade', 'like', '%' . $searchTerm . '%')
                  ->orWhere('cidade', 'like', '%' . $searchTerm . '%')
                  ->orWhere('contato', 'like', '%' . $searchTerm . '%');
            });
        }

        $clientes = $query->latest()->paginate(10)->withQueryString();

        return view('clientes.index', compact('clientes', 'status'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validatedData = $request->validate([
            'nome'              => 'required|string|max:255',
            'cpf'               => 'required|string|max:14|unique:clientes,cpf,NULL,id,user_id,' . $user->id,
            'rg'                => 'nullable|string|max:20',
            'telefone'          => 'nullable|string|max:20',
            'contato'           => 'required|string|max:15',
            'endereco'          => 'required|string|max:255',
            'cidade'            => 'required|string|max:255',
            'estado'            => 'required|string|max:50',
            'cep'               => 'required|string|max:10',
            'nome_propriedade'  => 'required|string|max:255',
            'area_total_ha'     => 'required|numeric|min:0.01',
            'cultura_principal' => 'nullable|string|max:100',
        ]);

        $user->clientes()->create($validatedData);

        return redirect()->route('clientes.index')->with('success', 'Cliente e propriedade adicionados com sucesso!');
    }

    public function show(Cliente $cliente)
    {
        $this->autorizar($cliente);
        return view('clientes.show', compact('cliente'));
    }

    public function edit(Cliente $cliente)
    {
        $this->autorizar($cliente);
        return view('clientes.edit', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $this->autorizar($cliente);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $validatedData = $request->validate([
            'nome'              => 'required|string|max:255',
            'cpf'               => 'required|string|max:14|unique:clientes,cpf,' . $cliente->id . ',id,user_id,' . $user->id,
            'rg'                => 'nullable|string|max:20',
            'telefone'          => 'nullable|string|max:20',
            'contato'           => 'required|string|max:15',
            'endereco'          => 'required|string|max:255',
            'cidade'            => 'required|string|max:255',
            'estado'            => 'required|string|max:50',
            'cep'               => 'required|string|max:10',
            'nome_propriedade'  => 'required|string|max:255',
            'area_total_ha'     => 'required|numeric|min:0.01',
            'cultura_principal' => 'nullable|string|max:100',
        ]);

        $cliente->update($validatedData);

        return redirect()->route('clientes.index')->with('success', 'Cliente e propriedade atualizados com sucesso!');
    }

    public function destroy(Cliente $cliente)
    {
        $this->autorizar($cliente);
        $cliente->update(['status' => false]);

        return redirect()->route('clientes.index')->with('success', 'Cliente inativado com sucesso!');
    }

    public function activate(Cliente $cliente)
    {
        $this->autorizar($cliente);
        $cliente->update(['status' => true]);

        return redirect()->route('clientes.index')->with('success', 'Cliente reativado com sucesso!');
    }

    private function autorizar(Cliente $cliente): void
    {
        if ($cliente->user_id !== Auth::id()) {
            abort(403, 'Acesso não autorizado a este cliente.');
        }
    }
}
