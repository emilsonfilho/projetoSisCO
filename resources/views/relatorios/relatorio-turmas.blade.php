@extends('layout.main-pure')

@section('title', 'Relatório Detalhado')

@section('content')
<style>
    .dashboard {
        padding-top: 25px !important;
    }
</style>
    <div class="dashboard" >
        <div class="btn-voltar" style="display: flex !important;">
            <h3>Exibindo relatório de <span style="font-weight: bold; font-style: italic;">{{ $nomeTurma }}</span></h3>
            <a class="" href="/turmas"><img src="/img/btnvoltar.svg" alt=""></a>
        </div>
        <div class="body">
        </div>
        <div class="bloco tab">
            <div class="table-body">
                <table>
                    <tr>
                        <th class="alinhado-esquerdas" scope="col">NOME</th>
                        <th class="short" scope="col">Nº MATRÍCULA</th>
                        <th class="short" scope="col">QNTD. OCORRÊNCIAS</th>
                        <th class="short" scope="col">QNTD. ALERTAS</th>
                        <th class="short" scope="col" id="consulta">CONSULTA</th>
                    </tr>
                    @if (count($alunos) != 0)
                        @foreach ($alunos as $aluno)
                            <tr>
                                <td class="bold"><a href="/consulta/{{ $aluno->discente_matricula }}" class="hover-underline"
                                        hreflang="pt-BR" target="_self">{{ $aluno->discente_nome }}</a></td>
                                <td class="meio cinza">{{ $aluno->discente_matricula }}</td>
                                <td class="num">{{ $numOcorrenciasAluno($aluno->discente_matricula) }}</td>
                                <td class="num">{{ $numEventosAluno($aluno->discente_matricula) }}</td>
                                {{-- LEMBRAR QUE TEM QUE PEGAR O COISA DAS OCORRÊNCIAS PARA FAZER ESSA BUSCA --}}
                                <td class="acao">
                                    <button type="submit" form="consulta_{{ $aluno->discente_matricula }}" hreflang="pt-BR" target="_self">
                                        <ion-icon name="search-outline"></ion-icon>
                                    </button>
                                </td>
                            </tr>
                            <form action="/consulta/{{ $aluno->discente_matricula }}" id="consulta_{{ $aluno->discente_matricula }}" method="GET"></form>
                        @endforeach
                    @else
                        <h3>Não há alunos nesta turma</h3>
                    @endif
                </table>
            </div>
        </div>
        <div class="contagem">
            <ul>
                <li>
                    <h5>{{ count($alunos) }} Alunos</h5>
                </li>
                <li>
                    <h5>{{ $numOcorrenciasTurma }} Ocorrências</h5>
                </li>
                <li>
                    <h5>{{ $numAlertasTurmas }} Alertas</h5>
                </li>
            </ul>
        </div>
    </div>
@endsection
