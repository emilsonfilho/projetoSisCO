@extends('layout.main')

@section('title', 'Dashboard Professores')

@section('content')
    @if ($tipoUser == 'PROFESSOR')
        <style>
            .bloco {
                max-width: 1000px;
            }
        </style>
    @endif
    

    <div class="bloco tab">
        <div class="header">
            <h1>Corpo docente escolar</h1>
        </div>
        <div class="table-body">
            <table>
                <tr>
                    <th class="alinhado-esquerda" scope="col">NOME</th>
                    <th class="short" scope="col">FUNÇÃO</th>
                    <th class="short" scope="col">TELEFONE</th>
                    @if ($tipoUser == 'ADM' || $tipoUser == 'COORDENADOR')
                        <th scope="col">AÇÕES</th>
                    @endif
                </tr>
                {{-- Fazer contagem depois para quando não houver registro no banco --}}
                @if (count($colaboradores) != 0)
                    @foreach ($colaboradores as $colaborador)
                        @if ($colaborador->colaborador_nome != 'Coordenador excluído do sistema')
                            @if ($colaborador->colaborador_nome != 'SISCO ADM')
                                <tr>
                                    @if ($tipoUser == 'ADM' || $tipoUser == 'COORDENADOR')
                                        <td class="bold"><a href="/editProf/{{ $user->id }}" class="hover-underline"
                                                hreflang="pt-BR" target="_self">{{ $colaborador->colaborador_nome }}</a></td>
                                    @else
                                        <td class="bold"><a href="#" class="hover-underline" hreflang="pt-BR"
                                                target="_self">{{ $colaborador->colaborador_nome }}</a></td>
                                    @endif
                                    <td class="meio cinza" style="width: 250px">{{ $getSetor($colaborador) }}</td>
                                    <td class="num">{{ $colaborador->colaborador_telefone }}</td>
                                    @if ($tipoUser == 'ADM' || $tipoUser == 'COORDENADOR')
                                        <td>
                                            <div class="acoes">
                                                <a href="/editProf/{{ $user->id }}" class="edit" hreflang="pt-BR"
                                                    target="_self" style="width: 17%;">
                                                    <ion-icon name="create-outline"></ion-icon>
                                                </a>
                                                <form action="/delProf/{{ $user->id }}" id="form_{{ $user->id }}"
                                                    class="delete-form" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="delete" hreflang="pt-BR" target="_self"
                                                        form="form_{{ $user->id }}" onclick="return confimarExclusao()">
                                                        <ion-icon name="close-circle-outline"></ion-icon>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endif
                        @endif
                    @endforeach
                @else
                    <h3>Não há usuários no banco.</h3>
                @endif
            </table>
        </div>
    </div>
@endsection
