<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Escola;

class ControllerCoordenadores extends Controller
{
   
    public function store(Request $request)
    {
        $coordenador = new User;
        try {
            $escola = Escola::findOrFail(1);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) { 
            return redirect()->back()->with('error', 'Não foi possível encontrar a escola.');
        }
        $coordenador->nome_user = mb_strtoupper($request->nome, 'UTF-8');
        $coordenador->email_user = $request->email;
        $coordenador->password = md5(base64_encode($request->senha));        
        $coordenador->dataN_user = $request->dataN;
        $coordenador->tipo_user = 'COORDENADOR';
        $coordenador->tel_user = $request->tel;
        $coordenador->escola_id = $escola->id;

        $coordenador->save();

        return redirect('/cadcoordenadores')->with('msg', 'Coordenador cadastrado com sucesso.');
    }
}
