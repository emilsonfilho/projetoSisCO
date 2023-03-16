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
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) { // Aqui dentro você pode deixar quieto, se quiser, mas anote o caso para que possamos ver o que fazemos com essa exceção depois 
        }
        $coordenador->nome_user = mb_strtoupper($request->nome, 'UTF-8');
        $coordenador->email_user = $request->email;
        $coordenador->password = md5(base64_encode($request->senha));

        // if ($request->hasFile('foto')) {
        //     if($request->file('foto')->isValid()) {
        //         $requestImage = $request->foto;
        //         $extension = $requestImage->extension();
        //         $imageName = md5($requestImage->getClientOriginalName() . strtotime('now') . '.' . $extension);
        //         $requestImage->move(public_path('img/users'), $imageName);
        //         $coordenador->img_user = $imageName;
        //     }
        // } else {
        //     $coordenador->img_user = "siscoUser.png";
        // }

        // Colocar uma solução para que a pessoa seja a validação seja antes do dia atual ou do ano atual 
        $coordenador->dataN_user = $request->dataN;

        $coordenador->tipo_user = 'COORDENADOR';
        $coordenador->tel_user = $request->tel;
        $coordenador->escola_id = $escola->id;

        $coordenador->save();

        return redirect('/cadcoordenadores')->with('msg', 'Coordenador cadastrado com sucesso.');
    }
}
