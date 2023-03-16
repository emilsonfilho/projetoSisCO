<?php

namespace App\Http\Controllers;

use App\Models\Escola;
use Illuminate\Http\Request;

class ControllerEscola extends Controller
{   
    public function show() {
        $escola = Escola::findOrFail(1);

        $nome = $escola->nome_escola;
        $endereco = $escola->endereco_escola;
        $inep = $escola->inep;
        $email = $escola->email_escola;
        $tel = $escola->tel_escola;
        $crede = $escola->crede;

        return view('content.escola', [
            'nome' => $nome, 
            'endereco' => $endereco,
            'inep' => $inep,
            'email' => $email,
            'tel' => $tel,
            'crede' => $crede
        ]);
    }

    public function edit(Request $request) {
        $escola = Escola::findOrFail(1);

        $escola->inep = $request->inep;
        $escola->nome_escola = $request->nome;
        $escola->email_escola = $request->email;
        $escola->endereco_escola = $request->end; 
        $escola->tel_escola = $request->fone;
        $escola->crede = $request->crede;
        $escola->save();

        return redirect('/escola')->with('msg', 'Edição concluída com sucesso.');
    }
}
