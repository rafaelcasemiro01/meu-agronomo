<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VisitaTecnicaController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Rotas de autenticação padrão do Laravel (login, register, reset, etc.)
// Ajustei para o seu login e registro customizados se necessário,
// mas o Auth::routes() é o padrão.
Auth::routes([
    'login'      => true,
    'register'   => true,
    'reset'      => true,
    'verify'     => false, // Conforme sua configuração
]);

// Rota para a tela de login (personalizada)
Route::get('/login', function () {
    return view('index'); // Aponta para resources/views/index.blade.php
})->name('login');

// Rota para a tela de registro (personalizada)
Route::get('/register', function () {
    return view('cadastro'); // Aponta para resources/views/cadastro.blade.php
})->name('register');

// Redireciona a rota raiz '/' para a tela de login
Route::get('/', function () {
    return redirect()->route('login');
});

// Este grupo de middleware garante que as rotas dentro dele
// só podem ser acessadas por usuários autenticados e verificados.
Route::middleware(['auth', 'verified'])->group(function () {

    // --- Rotas do Dashboard ---
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/home', function () { // Redireciona /home para /dashboard
        return redirect()->route('dashboard');
    })->name('home');

    // --- Rotas de Clientes (Resourceful) ---
    Route::resource('clientes', ClienteController::class);
    // Rota para reativar cliente (usando PATCH para atualização de status)
    Route::patch('/clientes/{cliente}/activate', [ClienteController::class, 'activate'])->name('clientes.activate');

    // --- Rotas de Perfil ---
    Route::prefix('perfil')->name('perfil.')->group(function () {
        Route::get('/info', [ProfileController::class, 'editInfo'])->name('info');
        Route::patch('/info', [ProfileController::class, 'updateInfo'])->name('update.info');

        Route::get('/senha', [ProfileController::class, 'editPassword'])->name('senha');
        Route::patch('/senha', [ProfileController::class, 'updatePassword'])->name('update.senha');
    });

    // --- Rotas de Visitas Técnicas ---
    Route::prefix('visitas')->name('visitas.')->group(function () {
        // Agendamento de Visita (formulário e salvamento)
        Route::get('/agendar', [VisitaTecnicaController::class, 'create'])->name('agendar');
        Route::post('/', [VisitaTecnicaController::class, 'store'])->name('store');

        // Listagem de Visitas
        Route::get('/minhas', [VisitaTecnicaController::class, 'minhasVisitas'])->name('minhas');

        // Rotas de Ações para Visitas (cancelar, realizar)
        Route::patch('/{visita}/cancelar', [VisitaTecnicaController::class, 'cancelar'])->name('cancelar');
        Route::patch('/{visita}/realizar', [VisitaTecnicaController::class, 'realizar'])->name('realizar'); // <-- NOVA ROTA AQUI
    });
    // Adicione mais rotas para CRUD completo de visitas se necessário no futuro
    // Ex: Route::get('/visitas/{visita}', [VisitaTecnicaController::class, 'show'])->name('visitas.show');
    // Ex: Route::get('/visitas/{visita}/edit', [VisitaTecnicaController::class, 'edit'])->name('visitas.edit');
    // Ex: Route::put('/visitas/{visita}', [VisitaTecnicaController::class, 'update'])->name('visitas.update');
    // Ex: Route::delete('/visitas/{visita}', [VisitaTecnicaController::class, 'destroy'])->name('visitas.destroy');
});
