<?php

namespace App\Http\Controllers;

use App\Models\User;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Controllerlogin extends Controller
{
    public function index(Request $request) {  
        $password = md5(base64_encode($request->senha)); // Parece que a senha está dando como diferente. Ver isso...
        $credentials = ['email_user' => $request->email, 'password' => $password];
        $users = User::all();
        
        foreach ($users as $user) {
            if (($user->email_user == $request->email) && ($user->password == md5(base64_encode($request->senha)))) {
                Auth::login($user);
                return redirect('/principal');
            } 
        }
        return redirect('/paginaLogin');
    }
}
