@extends('layout.forgot-password')

@section('title', 'Confirme seu e-mail')
    
@section('content')
    <form action="/confirmNumber" method="POST" id="confirmNumber">
        @csrf
        <h1>Login</h1>
        <p>Confirme seu número de telefone para que possamos renovar sua senha</p>
        <input type="text" name="num" id="iNum" required placeholder="(00) 0.0000-0000">
        <input type="hidden" name="email" id="iEmail" value="{{ $email }}">
        <button type="submit">OK</button>
    </form>
    
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
<script src="/js/loader.js"></script>
<script src="/js/jQuery/jquery.min.js"></script>
<script src="/js/jQuery/dist/jquery.validate.min.js"></script>
<script src="/js/jQuery/dist/additional-methods.min.js"></script>
<script src="/js/jQuery/dist/localization/messages_pt_BR.min.js"></script>
<script src="/js/jQuery/dist/jquery.mask.min.js"></script>
<script src="/js/jQuery/jquery-script.js"></script>
<script src="/js/app.js"></script>
<script src="/js/bootstrap.min.js"></script>
<script src="/js/script.js"></script>
<script src="/js/jQuery/btn-script.js"></script>
<script src="/js/main-js/app-mobile.js"></script>
<script src="/js/main-js/mobile-navbar.js"></script>
@endsection