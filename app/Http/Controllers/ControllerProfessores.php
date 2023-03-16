<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Escola;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ControllerProfessores extends Controller
{

    public function index() {
        $corpoDocente = User::all();

        return view('content.dashboard-professores', ['corpoDocente' => $corpoDocente]);
    }

    public function store(Request $request) {
        $professor = new User;
        $escola = Escola::findOrFail(1);

        $professor->nome_user = mb_strtoupper($request->nome, 'UTF-8'); 
        $professor->email_user = $request->email;
        $professor->password = md5(base64_encode($request->senha));

        // if ($request->hasFile('foto')) {
        //     if($request->file('foto')->isValid()) {
        //         $requestImage = $request->foto;
        //         $extension = $requestImage->extension();
        //         $imageName = md5($requestImage->getClientOriginalName() . strtotime('now') . '.' . $extension);
        //         $requestImage->move(public_path('img/users'), $imageName);
        //         $professor->img_user = $imageName;
        //     }
        // } else {
        //     $professor->img_user = "siscoUser.png";
        // }

        // Colocar uma solução para que a pessoa seja a validação seja antes do dia atual ou do ano atual 
        $professor->dataN_user = $request->dataN;

        $professor->tipo_user = 'PROFESSOR';
        $professor->tel_user = $request->tel;
        $professor->escola_id = $escola->id;

        $professor->save(); 

        return redirect('/professores')->with('msg', 'Professor cadastrado com sucesso.');
    }

    public function edit($id) {
        // $user = User::where('id', $id)->first();
        $user = User::findOrFail($id);
        $nome = $user->nome_user;
        $email = $user->email_user;
        // $img = $user->img_user;
        $dataN = $user->dataN_user;
        $tipo = $user->tipo_user;
        $tel = $user->tel_user;
        
        return view('content.edit-professor', [
            'nome' => $nome, 
            'email' => $email, 
            // 'img' => $img, 
            'dataN' => $dataN, 
            'tipo' => $tipo, 
            'tel' => $tel,
            'id' => $id
        ]);
    }

    public function destroy($id) {
        try {
            $novoCoordenador = User::where('nome_user', 'Coordenador excluído do sistema')->first();
            $idNovoCoordenador = $novoCoordenador->id;
            DB::table('ocorrencias')->where('users_id', $id)->update(['users_id' => $idNovoCoordenador]);
            User::findOrFail($id)->delete();

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            throw new Error('Usuário não encontrado');        }
        
        return redirect('/professores')->with('msg', 'Usuário removido com sucesso.');
    }

    public function update($id, Request $request) {
        try { 
            $user = User::findOrFail($id);
        }
            
        catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e){//
        }
        
        
        $user->nome_user = mb_strtoupper($request->nome, 'UTF-8'); 
        $user->email_user = $request->email;
        $user->password = $user->password;
        // $user->img_user = $user->img_user; // Lembra que isso pode ser apagado
        $user->dataN_user = $request->dataN;
        $user->tipo_user = $user->tipo_user;
        $user->tel_user = $request->tel;
        $user->escola_id = $user->escola_id;

        $user->save();

        return redirect('/professores')->with('msg', 'Usuário editado com sucesso.');
    }
}
