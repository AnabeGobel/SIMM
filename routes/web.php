<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OperadorController; 
use App\Http\Controllers\MotoqueiroController; 
use App\Http\Controllers\AssociacaoController;
use App\Http\Controllers\OcorrenciaController; 
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MotoController; 
use App\Http\Controllers\ParagemController; 
use App\Http\Controllers\UsuarioController; 
use App\Http\Controllers\relatorioController; 
use App\Http\Controllers\backupController; 
use App\Http\Controllers\PerfilMOperatotController; 



// Pagina Inical
Route::get('', function () {
    return view('index');
});



                                //***Autenticacao***//
       //0.1  Mostrar formulário de login
Route::get('/login', [AuthController::class, 'index'])->name('login.index');
Route::post('/login', [AuthController::class, 'process'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

       //0.2-- rotas do Painel do Administrador
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'dashboard'])->name('admin.home');
});
       //0.2-- rotas do Painel do Operador
 Route::middleware(['auth', 'operador'])->group(function () {
    Route::get('/operador', [OperadorController::class, 'index'])
        ->name('operador.home2');
});





                               //***Rotas do Usuario***//
//0.1 rotas de visualizacao
       Route::get('/usuario', [UsuarioController::class, 'index'])->name('Adm.usuario');

//0.2 rotas para o registro
       Route::middleware(['auth', 'admin'])->group(function () {
        Route::post('/usuarios/store', [UsuarioController::class, 'store'])->name('usuarios.store');
           });


//0.4 Rotas para usuários (CRUD completo)
            Route::prefix('index')->middleware('auth')->group(function () {
                Route::resource('usuarios', UsuarioController::class);
            });



        
            
                           //.....rotas do painel do usuario adimistrador......//

// 1---Rotas do Painel Admistrator
     //1.1 Rotas para Visualizacao
       Route::get('/admin', [DashboardController::class, 'index'])->name('admin.home');
      //1.2 Rotas  de Busca
       Route::get('/admin/busca', [DashboardController::class, 'search']) ->name('admin.dashboard.search');

// 2---Rotas de Navegacao
        Route::get('/admin/usuarios', [UsuarioController::class, 'index'])->name('Adm.usuario');
        Route::post('/admin/usuarios', [UsuarioController::class, 'store'])->name('usuarios.store');
        Route::get('/admin/usuarios/{id}/edit', [UsuarioController::class, 'edit'])->name('usuarios.edit');
        Route::put('/admin/usuarios/{id}', [UsuarioController::class, 'update'])->name('usuarios.update');
        Route::delete('/admin/usuarios/{id}', [UsuarioController::class, 'destroy'])->name('usuarios.destroy');

// 3--rotas do motoqueiro
       //3.1 rotas para visualizacao
      Route::get('/perfiMo', [MotoqueiroController::class, 'index'])->name('Adm.motoqueiro');
      Route::prefix('admin')->name('admin.')->group(function () {
      Route::resource('motoqueiros', MotoqueiroController::class);
       });
      // 3.2 protas para registro
        Route::post('/admin/motoqueiros', [MotoqueiroController::class, 'store'] )->name('admin.motoqueiros.store');       
        // 3.3 rotas para funcoes de remover e atualizar
        Route::put('/admin/motoqueiros/{id}', [MotoqueiroController::class, 'update'])->name('admin.motoqueiros.update');
        Route::delete('/admin/motoqueiros/{id}', [MotoqueiroController::class, 'destroy']) ->name('admin.motoqueiros.destroy');

//4--rotas da moto
        //4.1 rotas de visualizacao
        Route::get('/moto', [MotoController::class, 'index'])->name('Adm.moto');
        Route::prefix('admin')->middleware('auth')->group(function () {
            Route::resource('motos', MotoController::class);
        });
        //4.2 rotas para o registro
        Route::post('/admin/motos', [MotoController::class, 'store'])->name('admin.motos.store');
        //4.3 rotas para o registro da paragem
        Route::post('/admin/paragens',
        [ParagemController::class, 'store'] )->name('admin.paragens.store');
        // 4.4 rotas para  funcoes de remover e atualizar
        Route::put('/admin/motos/{id}', [MotoController::class, 'update'])->name('admin.motos.update');
        Route::delete('/admin/motos/{id}', [MotoController::class, 'destroy'])->name('admin.motos.destroy');

//5- rotas para associacao
        //5.1 rotas de visualizacacao
            Route::get('/associacao', [AssociacaoController::class, 'index'])->name('Adm.associacao');
        //5.2 rotas para o registro
            Route::prefix('admin')->group(function () {
            Route::resource('associacao', AssociacaoController::class);
            });

// 6- Rotas para Relatorios
         // 6.1 Rotas de Visualizacacao
         Route::get('/relatorios', [relatorioController::class, 'index'])->name('Adm.relatorios');

// 7- Rotas para o Backup
        //7.1 Rotas de Visualizacao
        Route::get('/backup', [backupController::class, 'index'])->name('Adm.backup');

// 8- rotas do perfil
    Route::middleware('auth')->group(function () {
    // Página de perfil
    Route::get('/Admperfil', [AdminController::class, 'perfilAdm'])->name('perfilAdm');
    // Atualizar dados (nome, email, telefone)
    Route::post('/Admperfil/atualizar', [AdminController::class, 'atualizarperfilAdm'])->name('perfilAdm.atualizar');
    // Atualizar foto
    Route::post('/Admperfil/foto', [AdminController::class, 'atualizarFotoperfilAdm'])->name('perfilAdm.foto');
    // Alterar senha
    Route::post('/Admperfil/senha', [AdminController::class, 'alterarSenhaperfilAdm'])->name('perfilAdm.senha');
    // Excluir conta
    Route::delete('/Admperfil/excluir', [AdminController::class, 'excluirContaperfilAdm'])->name('perfilAdm.excluir');
});





                      //.....rotas do painel do usuario Operador......//
//1- Rotas do Perfim Motoqueiro
    //1.1- Rotas de Visualizacao
            Route::get('/Perfil-Motoqueiro', [PerfilMOperatotController::class, 'index'])->name('operation.perfiMo');

//2- Rotas do Perfim Usuario
     Route::middleware('auth')->group(function () {
            // Página de perfil
            Route::get('/perfil', [OperadorController::class, 'perfil'])->name('perfil');
            // Atualizar dados (nome, email, telefone)
            Route::post('/perfil/atualizar', [OperadorController::class, 'atualizarPerfil'])->name('perfil.atualizar');
            // Atualizar foto
            Route::post('/perfil/foto', [OperadorController::class, 'atualizarFoto'])->name('perfil.foto');
            // Alterar senha
            Route::post('/perfil/senha', [OperadorController::class, 'alterarSenha'])->name('perfil.senha');
            // Excluir conta
            Route::delete('/perfil/excluir', [OperadorController::class, 'excluirConta'])->name('perfil.excluir');
    });

//3- Rotas de historico/ocorrencia
     // 3.1---Ritas para Visualizacao
      Route::get('/operador/ocorrencias', [OcorrenciaController::class, 'index'])->name('operador.ocorrencia');
     // 3.2--- Rotas para Atualizacao
        Route::post('/operador/ocorrencias', [OcorrenciaController::class, 'store'])->name('operador.ocorrencias.store');
     // 3.3--- Rotas para remocao
        Route::delete('/operador/ocorrencias/{id}', [OcorrenciaController::class, 'destroy'])->name('operador.ocorrencias.destroy');

//4- Rotas do Perfim Usuario
            //4.1- Rotas de Historico
            Route::get('/relatorio', [relatorioController::class, 'index'])->name('operation.relatorio');
    
 


















