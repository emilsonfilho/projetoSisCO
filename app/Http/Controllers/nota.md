$dados = User::all();
        foreach ($dados as $dado) {
            if (($dado->email_user == $request->email) && ($dado->password == $request->senha)) {
                // Significa que o email é igual
                return view('content.principal');
                
            } else {
                throw new Error('E-mail ou senha não encontradas.');
            }
        }

        // for ($i=0; $i < count($dados); $i++) { 
        //     $dado = $dados[$i];
        // }
        # code...
        // input name="email"
        // $email = $request->email;

        // $emailsBanco = User::all();