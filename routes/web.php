<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AuthController, AdminController, OperadorController, MotoqueiroController,
    AssociacaoController, OcorrenciaController, DashboardController,
    MotoController, ParagemController, UsuarioController, relatorioController,
    backupController, PerfilMOperatotController
};

// --- PAGINA INICIAL ---
Route::get('/', function () { return view('index'); });

// --- AUTENTICAÇÃO ---
Route::get('/login', [AuthController::class, 'index'])->name('login.index');
Route::post('/login', [AuthController::class, 'process'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- PAINEL ADMINISTRADOR (Tudo que é ADMIN fica aqui) ---
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    
    // Dashboard e Busca
    Route::get('/', [DashboardController::class, 'index'])->name('admin.home');
    Route::get('/busca', [DashboardController::class, 'search'])->name('admin.dashboard.search');

    // USUÁRIOS (Apenas esta definição é necessária)
    Route::get('/usuarios', [UsuarioController::class, 'index'])->name('Adm.usuario');
    Route::post('/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
    Route::get('/usuarios/{id}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit');
    Route::put('/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
    Route::delete('/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');

    // MOTOQUEIROS
    Route::resource('motoqueiros', MotoqueiroController::class)->names('admin.motoqueiros');

    // MOTOS E PARAGENS
    Route::resource('motos', MotoController::class)->names('admin.motos');
    Route::post('/paragens', [ParagemController::class, 'store'])->name('admin.paragens.store');

    // ASSOCIAÇÃO, RELATÓRIOS E BACKUP
    Route::resource('associacao', AssociacaoController::class)->names('associacao');
    Route::get('/relatorios', [relatorioController::class, 'index'])->name('Adm.relatorios');
    Route::get('/backup', [backupController::class, 'index'])->name('Adm.backup');

    // PERFIL ADMIN
    Route::get('/perfilAdm', [AdminController::class, 'perfilAdm'])->name('perfilAdm');
    Route::post('/perfilAdm/atualizar', [AdminController::class, 'atualizarperfilAdm'])->name('perfilAdm.atualizar');
    Route::post('/perfilAdm/foto', [AdminController::class, 'atualizarFotoperfilAdm'])->name('perfilAdm.foto');
    Route::post('/perfilAdm/senha', [AdminController::class, 'alterarSenhaperfilAdm'])->name('perfilAdm.senha');
    Route::delete('/perfilAdm/excluir', [AdminController::class, 'excluirContaperfilAdm'])->name('perfilAdm.excluir');
});

// --- PAINEL OPERADOR ---
Route::middleware(['auth', 'operador'])->prefix('operador')->group(function () {
    
    Route::get('/', [OperadorController::class, 'index'])->name('operador.home2');
    Route::get('/perfil-motoqueiro', [PerfilMOperatotController::class, 'index'])->name('operation.perfiMo');
    Route::get('/relatorio-operador', [relatorioController::class, 'index'])->name('operation.relatorio');

    // Ocorrências
    Route::get('/ocorrencias', [OcorrenciaController::class, 'index'])->name('operador.ocorrencia');
    Route::post('/ocorrencias', [OcorrenciaController::class, 'store'])->name('operador.ocorrencias.store');
    Route::delete('/ocorrencias/{id}', [OcorrenciaController::class, 'destroy'])->name('operador.ocorrencias.destroy');

    // Perfil Operador
    Route::get('/perfil', [OperadorController::class, 'perfil'])->name('perfil');
    Route::post('/perfil/atualizar', [OperadorController::class, 'atualizarPerfil'])->name('perfil.atualizar');
    Route::post('/perfil/foto', [OperadorController::class, 'atualizarFoto'])->name('perfil.foto');
    Route::post('/perfil/senha', [OperadorController::class, 'alterarSenha'])->name('perfil.senha');
    Route::delete('/perfil/excluir', [OperadorController::class, 'excluirConta'])->name('perfil.excluir');
});