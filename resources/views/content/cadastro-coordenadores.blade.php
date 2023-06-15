@extends('layout.main')

@section('title', 'Cadastro de Coordenadores')

@section('content')

    <div class="bloco cad">
        <div class="header">
            <h1>Cadastro de coordenadores</h1>
        </div>
        <div class="body">
            <div class="body-form">
                <form action="/novocoordenador" method="POST" enctype="multipart/form-data" id="formCadastro">
                    @csrf
                    <div class="line">
                        <input type="text" name="nome" id="iNome" placeholder="Nome coordenador" class="w100 uppercase"
                            required>
                    </div>
                    <div class="line">
                        <input type="email" name="email" id="iEmail" placeholder="E-mail coordenador" class="w100"
                            autocomplete="email" required >
                    </div>
                    <div class="line">
                        <input type="date" name="dataN" id="iDataN" placeholder="dd/mm/aaaa" class="w50"
                            required>
                        <input type="tel" name="tel" id="iTel" placeholder="(**) *.****-****" class="w50"
                            required>
                    </div>
                    <div class="line">
                        <input type="password" name="senha" id="iSenha" placeholder="Senha" class="w70"
                            minlength="8" required>
                    </div>
                    <button id="cadastrar" type="submit" name="btn"><span>Cadastrar</span></button>
                </form>
            </div>
            @if (session('msg'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('msg') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>
    
@endsection
