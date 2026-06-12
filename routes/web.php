<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VisitaTecnicaController;
use App\Http\Controllers\RelatorioController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Auth::routes([
    'login'    => true,
    'register' => true,
    'reset'    => true,
    'verify'   => false,
]);

Route::get('/login', function () {
    return view('index');
})->name('login');

Route::get('/register', function () {
    return view('cadastro');
})->name('register');

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth', 'verified'])->group(function () {

    // --- Dashboard ---
    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');
    Route::get('/home', function () {
        return redirect()->route('dashboard');
    })->name('home');

    // --- Clientes ---
    Route::resource('clientes', ClienteController::class);
    Route::patch('/clientes/{cliente}/activate', [ClienteController::class, 'activate'])->name('clientes.activate');
    // Exclusão DEFINITIVA (diferente de inativar)
    Route::delete('/clientes/{cliente}/excluir', [ClienteController::class, 'forceDestroy'])->name('clientes.force');

    // --- Perfil ---
    Route::prefix('perfil')->name('perfil.')->group(function () {
        Route::get('/info', [ProfileController::class, 'editInfo'])->name('info');
        Route::patch('/info', [ProfileController::class, 'updateInfo'])->name('update.info');
        Route::get('/senha', [ProfileController::class, 'editPassword'])->name('senha');
        Route::patch('/senha', [ProfileController::class, 'updatePassword'])->name('update.senha');
    });

    // --- Visitas Técnicas ---
    Route::prefix('visitas')->name('visitas.')->group(function () {
        Route::get('/agendar', [VisitaTecnicaController::class, 'create'])->name('agendar');
        Route::post('/', [VisitaTecnicaController::class, 'store'])->name('store');
        Route::get('/minhas', [VisitaTecnicaController::class, 'minhasVisitas'])->name('minhas');
        Route::patch('/{visita}/cancelar', [VisitaTecnicaController::class, 'cancelar'])->name('cancelar');
        Route::patch('/{visita}/realizar', [VisitaTecnicaController::class, 'realizar'])->name('realizar');
        // Desfaz "realizada"/"cancelada" → volta para "agendada"
        Route::patch('/{visita}/reabrir', [VisitaTecnicaController::class, 'reabrir'])->name('reabrir');
    });

    // --- Relatórios ---
    Route::resource('relatorios', RelatorioController::class);
    Route::patch('/relatorios/{relatorio}/finalizar', [RelatorioController::class, 'finalizar'])->name('relatorios.finalizar');
});
