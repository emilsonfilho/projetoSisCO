@extends('layout.main-pure')

@section('title', 'Editar Ocorrência')

@section('content')
    <div class="bloco individual" style="margin-top: 64px">
        <div id="cadastro-ocorrencias" class="bloco cad">
            <div class="header">
                <h1>Edição de Ocorrências</h1>
            </div>
            <div class="body">
                <div class="body-form">
                    <form action="/editOcorrenciaForm/{{ $ocorrencia->ocorrencia_id }}" method="POST" autocomplete="on" id="form">
                        @csrf

                        <div class="line">
                            <input type="text" name="nomeAluno" id="nome_aluno" placeholder="Nome do aluno"
                                class="w70" list="alunos" autocomplete="off" value="{{ $discente->discente_nome }}">
                            @php
                                $students = [];
                                $cursos = [];
                                $turmasJS = [];
                            @endphp
                            <datalist id="alunos">
                                @for ($i = 0; $i < count($alunos); $i++)
                                    <option value="{{ $alunos[$i]->discente_nome }}">{{ $alunos[$i]->discente_nome }}</option>
                                    @php
                                        $students[] = $alunos[$i];
                                        $cursos[] = $getCursoNome($alunos[$i]->discente_idTurma);
                                        $turmasJS[] = $getTurma($alunos[$i]->discente_idTurma);
                                    @endphp
                                @endfor
                            </datalist>
                            @php
                                
                            @endphp

                            @php
                                echo '<script>
                                    ';
                                    echo 'var alunosJS = '.json_encode($students).
                                    ";";
                                    echo 'var cursos = '.json_encode($cursos).
                                    ";";
                                    echo 'var turmas = '.json_encode($turmasJS).
                                    ";";
                                    echo '
                                </script>';
                            @endphp

                            <input type="text" name="matricula" id="iMatricula" placeholder="Matrícula" disabled
                                class="w30" required value="{{ $discente->discente_matricula }}">
                        </div>
                        <div class="line">
                            <input type="email" name="email" id="iEmail" placeholder="E-mail institucional"
                                disabled class="w70" autocomplete="email" required value="{{ $discente->discente_email }}">
                            <input type="text" name="ano" id="iAno" placeholder="Série + Curso" disabled
                                class="w30" required value="{{ $getTurma($discente->discente_idTurma) }}">
                        </div>
                        <div class="line">
                            <input type="time" name="hora" id="iHora" class="w50" value="{{ $ocorrencia->ocorrencia_hora }}">
                            <input type="date" name="data" id="iData" class="w50" value="{{ $ocorrencia->ocorrencia_data }}">
                        </div>
                        <div class="line wrap">
                            {{-- OBS: esses valores serão conforme o banco de dados mais para o frente --}}
                            @foreach ($motivosOcorrencias as $motivo)    
                                <div class="item-radio">
                                    <input type="radio" name="motivo" value={{ $motivo->ocorrenciaMotivo_id }} id={{ $motivo->ocorrenciaMotivo_id }}
                                    @if ($ocorrencia->ocorrencia_idMotivo === $motivo->ocorrenciaMotivo_id)
                                        checked
                                    @endif
                                    >
                                    <label for="telefone">{{ $motivo->ocorrenciaMotivo_nome }}</label>
                                </div>
                            @endforeach
                        </div>
                        <textarea placeholder="Observação" name="obs">{{ $ocorrencia->ocorrencia_descricao }}</textarea>
                        <button id="concluir" type="submit"><span>Concluir</span></button>
                        <script>
                            let input = document.getElementById("nome_aluno")
                            let email = document.getElementById('iEmail')
                            let matricula = document.getElementById('iMatricula')
                            let turma = document.getElementById('iAno')
                            input.addEventListener('change', function() {
                                let nome = input.value
                                for (let i = 0; i < alunosJS.length; i++) {
                                    if (alunosJS[i].discente_nome === nome) {
                                        email.value = alunosJS[i].discente_email
                                        matricula.value = alunosJS[i].discente_matricula
                                        turma.value = turmas[i]
                                    }
                                }
                            })
                        </script>
                    </form>
                    @if (session('msg'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('msg') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

@endsection