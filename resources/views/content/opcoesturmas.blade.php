@extends('layout.main')

@section('title', 'Selecione a Turma')

@section('content')
<div class="flex-center bloco" id="opcoes-turmas">
    <div class="bloco">
        <div class="header btn-voltar" id="header-select">
            <h1>Selecione a Turma</h1> 
            <a href="/principal"><img src="/img/btnvoltar.svg" alt=""></a>
        </div>
        <div class="table-body">
            <table>
                <tr>
                    <th class="alinhado-esquerda">NOME DA TURMA</th>
                    <th>AÇÃO</th>
                </tr>
                @for ($i = 0; $i < count($turmas); $i++)
                <tr>
                    <td class="alinhado-esquerda bold" id="td-select"><a href="/relturmas/{{ $turmas[$i]->id }}" class="hover-underline" hreflang="pt-BR" target="_self">{{ date("Y") - ($turmas[$i]->ano) + 1 }}º Ano - @php echo $nomeCurso($turmas[$i]); @endphp</a></td>
                    <td class="acao"><button type="submit" name="visualizar" id="iVisualizar"><a href="/relturmas/{{ $turmas[$i]->id }}" hreflang="pt-BR" target="_self"><ion-icon name="eye-outline"></ion-icon></a></button></td>
                </tr>
                @endfor
            </table>
        </div>
    </div>
</div>
@endsection