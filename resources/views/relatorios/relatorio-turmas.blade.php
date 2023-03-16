@extends('layout.main')

@section('title', 'Relatório Detalhado')

@section('content')
    <div class="dashboard">
        <div class="btn-voltar" style="display: flex !important;">
            <h3>Exibindo relatório de <span style="font-weight: bold; font-style: italic;">{{ $nomeTurma }}</span></h3>
            <a href="/turmas"><img src="/img/btnvoltar.svg" alt=""></a>
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
                        <th class="short" scope="col">CONSULTA</th>
                    </tr>
                    @if (count($alunos) != 0)
                        @foreach ($alunos as $aluno)
                            <tr>
                                <td class="bold"><a href="/consulta/{{ $aluno->id }}" class="hover-underline"
                                        hreflang="pt-BR" target="_self">{{ $aluno->nome_aluno }}</a></td>
                                <td class="meio cinza">{{ $aluno->matricula }}</td>
                                <td class="num">{{ $aluno->qntd_ocorrencias_assinadas }}</td>
                                <td class="num">{{ $aluno->qntd_alertas }}</td>
                                <td class="acao">
                                    <button type="submit" form="consulta_{{ $aluno->id }}" hreflang="pt-BR" target="_self">
                                        <ion-icon name="search-outline"></ion-icon>
                                    </button>
                                </td>
                            </tr>
                            <form action="/consulta/{{ $aluno->id }}" id="consulta_{{ $aluno->id }}" method="GET"></form>
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
                    <h5>X Suspensões</h5>
                </li>
            </ul>
        </div>
    </div>
@endsection
