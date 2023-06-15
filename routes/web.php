<?php

use App\Http\Controllers\Controller;
use App\Http\Controllers\ControllerAluno;
use App\Http\Controllers\ControllerCoordenadores;
use App\Http\Controllers\ControllerCursos;
use App\Http\Controllers\ControllerSisco;
use App\Http\Controllers\ControllerTurmas;
use App\Http\Controllers\ControllerProfessores;
use App\Http\Controllers\ControllerEscola;
use Illuminate\Console\Scheduling\Event;
use App\Http\Controllers\Controllerlogin;
use App\Models\User;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/paginaLogin', function () {
    return view('index');
})->name('paginaLogin');

Route::get('/principal', [ControllerSisco::class, 'index'])->middleware('auth');

Route::get('/turmas', [ControllerTurmas::class, 'index'])->middleware('auth');

Route::get('/professores', [ControllerProfessores::class, 'index'])->middleware('auth');

Route::get('/cadcoordenadores', function() {
    $idUser = auth()->id();
    $tipoUser = User::findOrFail($idUser)->tipo_user;
    return view('content.cadastro-coordenadores', ['tipoUser' => $tipoUser]);
})->middleware('auth');

Route::get('/escola', [ControllerEscola::class, 'show'])->middleware('auth');

Route::get('/manual', function() {
    $idUser = auth()->id();
    $tipoUser = User::findOrFail($idUser)->tipo_user;
    return view('content.manual',['tipoUser' => $tipoUser]);
})->middleware('auth');

Route::post('/ocorrencia', [ControllerSisco::class, 'store']);

Route::post('/novoprofessor', [ControllerProfessores::class, 'store']);

Route::post('/editEscola', [ControllerEscola::class, 'edit']);

Route::post('/novocoordenador', [ControllerCoordenadores::class, 'store']);

Route::post('/novaturma', [ControllerTurmas::class, 'store']);

Route::get('/cadCurso', [ControllerCursos::class, 'index'])->middleware('auth');

Route::post('/novocurso', [ControllerCursos::class, 'store']);

Route::get('/editProf/{id}', [ControllerProfessores::class, 'edit']);

Route::delete('/delProf/{id}', [ControllerProfessores::class, 'destroy']);

Route::get('/cadAlunos', [ControllerAluno::class, 'index'])->middleware('auth');

Route::post('/aluno', [ControllerAluno::class, 'store']);

Route::post('/aluno-csv', [ControllerAluno::class, 'storeCSV']);

Route::post('/updateUser/{id}', [ControllerProfessores::class, 'update']);

Route::get('/relturmas/{id}', [ControllerTurmas::class, 'relatorioIndex'])->middleware('auth');

Route::get('/cadastro-por-csv', function(){
    $idUser = auth()->id();
    $tipoUser = User::findOrFail($idUser)->tipo_user;
    return view('content.cadastro-csv', ['tipoUser' => $tipoUser]);
})->middleware('auth');

Route::post('/autenticacao', [Controllerlogin::class, 'index']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/consulta/{id}', [ControllerTurmas::class, 'search'])->middleware('auth');

Route::post('/concluido/{id}', [ControllerSisco::class, 'marked'])->middleware('auth');

Route::delete('/delAluno/{id}', [ControllerAluno::class, 'destroy'])->middleware('auth');

Route::get('/editAluno/{id}', [ControllerAluno::class, 'show'])->middleware('auth');

Route::put('/updateAluno/{id}', [ControllerAluno::class, 'update'])->middleware('auth');

Route::post('/logOut', [ControllerSisco::class, 'logout'])->middleware('auth');

Route::get('/forgotPassword', function() {
    return view('auth.email');
});

Route::post('/confirmLogin', [ControllerSisco::class, 'confirmLogin']);

Route::post('/confirmNumber', [ControllerSisco::class, 'confirmNumber']);

Route::post('/newPassword', [ControllerSisco::class, 'newPass']);