@extends('layout.forgot-password')

@section('title', 'Digite o token de verificação')
    
@section('content')
    <form action="/newPassword" method="POST">
        @csrf
        <h1>Login</h1>
        <h2>Por favor, digite uma nova senha</h2>
        <input type="password" name="pass" id="iPass" required placeholder="Nova senha" minlength="8" max="255">
        <input type="password" name="confirmPass" id="iConfirmPass" required placeholder="Confirme a nova senha" minlength="8" max="255">
        <input type="hidden" name="email" value="{{ $email }}">
        <button type="submit">Finalizar</button>
    </form>
    <script>
        const btn = document.querySelector('button')
        btn.addEventListener('click', (event) => {
            event.preventDefault()
            const pass = document.querySelector('#iPass').value
            const confirm = document.querySelector('#iConfirmPass').value
            const form = document.querySelector('form')
            if (pass == confirm) {
                form.submit()
            } else {
                const div = document.createElement('div')
                div.innerText = "Senhas não coincidem"
                div.style.color = "red"
                form.appendChild(div)
            }
        })
    </script>
@endsection