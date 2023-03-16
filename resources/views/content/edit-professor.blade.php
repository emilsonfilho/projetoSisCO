@extends('layout.main')

@section('title', "Editando: $nome")
    
@section('content')
<div class="bloco cad edicao">
   
        <div class="header">
            <h1>Editando: <span>{{ $nome }}</span></h1>
            <a href="/professores"><img src="/img/btnvoltar.svg" alt=""></a>
        </div>
    </a>
    <div class="body">
        <div class="body-form">
          <form action="/updateUser/{{ $id }}" method="POST" enctype="multipart/form-data" id="formEdit">
            @csrf
            {{-- <img src="/img/users/{{ $img }}" alt="" class="foto-demo"> --}}
              <div class="line">
                  <input type="text" name="nome" id="iNome" placeholder="Nome" value="{{ $nome }}" class="w100" required>
              </div>
              <div class="line">
                  <input type="email" name="email" id="iEmail" placeholder="E-mail" value="{{ $email }}" class="w100" autocomplete="email" required>
              </div>
              <div class="line">
                  <input type="date" name="dataN" id="iDataN" placeholder="dd/mm/aaaa" value="{{ $dataN }}" class="w50" required>
                  <input type="tel" name="tel" id="iTel" placeholder="(**) *.****-****" value="{{ $tel }}" class="w50" required>
              </div>
              {{-- <div class="line">
                  <input type="file" name="foto" id="iFoto" placeholder="Arquivo de foto" class="w100">
              </div> --}}
              <button id="editar" type="submit" name="btn"><span>Editar</span></button>
          </form>
        </div>
    </div>
</div>
@endsection