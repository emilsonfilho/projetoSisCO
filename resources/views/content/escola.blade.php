@extends('layout.main')

@section('title', 'Dados da Instituição')

@section('content')
    <div class="bloco cad">
        <div class="header">
            <h1>Editando: <span>{{ $nome }}</span></h1>
        </div>
        <div class="body">
            <div class="body-form">
                <form action="/editEscola" method="POST" id="form">
                    @csrf

                    <div class="line">
                        <input type="text" name="nome" id="iNome" placeholder="Nome da instituição"
                            value="{{ $nome }}" class="w70">
                        <input type="number" name="inep" id="iINEP" placeholder="INEP" value="{{ $inep }}"
                            class="w30" required>
                    </div>
                    <div class="line">
                        <input type="email" name="email" id="iEmail" placeholder="E-mail de contato"
                            value="{{ $email }}" class="w70" autocomplete="email" required>
                        <input type="tel" name="fone" id="iFone" placeholder="Telefone"
                            value="{{ $tel }}" class="w30" required>
                    </div>
                    <div class="line">
                        <input type="text" name="end" id="iEnd" placeholder="Endereço de localização"
                            value="{{ $endereco }}" class="w70" required>
                        <input type="num" name="crede" id="iCrede" placeholder="CREDE" value="{{ $crede }}"
                            class="w30" required>
                    </div>
                    <button id="editar" type="submit" name="btn"><span>Editar</span></button>
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
