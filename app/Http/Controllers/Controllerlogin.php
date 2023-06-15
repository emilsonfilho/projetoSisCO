<?php

namespace App\Http\Controllers;

use App\Models\Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Controllerlogin extends Controller
{
    public function index(Request $request)
    {
        $usuario = DB::table('tb_jmf_usuario')
            ->where('usuario_login', $request->input('email'))
            ->where('usuario_senha', $request->input('senha'))
            ->first();

        if ($usuario) {
            Auth::loginUsingId($usuario->usuario_id);
            return redirect()->intended('/principal');
        } else {
            return redirect()->back()->with('message', 'Email ou senha inválidos');
        }
    }
}
