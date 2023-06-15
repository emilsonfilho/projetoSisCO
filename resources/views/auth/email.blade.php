@extends('layout.forgot-password')

@section('title', 'Digite seu e-mail')

@section('content')
    <form action="/confirmLogin" method="POST">
        @csrf
        <h1>Recuperar senha</h1>
        <h2>Para recuperar a senha, por favor, informe seu nome de usuário (login).</h2>
        <input type="text" name="login" id="iLogin" required placeholder="E-mail">
        <button type="submit">Enviar E-mail</button>
    </form>
@endsection
