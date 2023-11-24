<?php
include_once("../include/header.php");
if (isset($_GET['sisco'])) {
  $acao = $_GET['sisco'];
  if ($acao == 'cadOcorrencia') {
    include_once('cadOcorrencia.php');
  } elseif ($acao == 'corpoDoscente') {
    include_once('corpoDoscente.php');
  } elseif ($acao == 'relatorioTurmas') {
    include_once('relacaoTurmas.php');
  } elseif ($acao == 'relatorioIndividual') {
    if (isset($_GET['idTurma'])) {
      include_once('relatorioIndividual.php');
    } else {
      echo "ID da turma não encontrado.";
    }
  } elseif ($acao == 'detalhesDiscente') {
    if (isset($_GET['matricula'])) {
      include_once('detalhesDiscente.php');
    } else {
      echo "Matrícula do aluno não encontrada";
    }
  } elseif ($acao == 'editOcorrencia') {
    if (isset($_GET['idOcorrencia'])) {
      include_once('editOcorrencia.php');
    } else {
      echo "ID da ocorrência não encontrado.";
    }
  } elseif ($acao == 'cadEventos') {
    include_once('cadEvento.php');
  } elseif ($acao == 'editEvento') {
    if (isset($_GET['idEvento'])) {
      include_once('editEvento.php');
    } else {
      echo "ID do evento não encontrado.";
    }
  } elseif ($acao == 'liberacao') {
    include_once('liberacao.php');
  } elseif ($acao == 'detalhesLiberacao') {
    if (isset($_GET['idLiberacao'])) {
      include_once('detalhesLiberacao.php');
    } else {
      echo "ID da liberação não encontrado.";
    }
  } elseif ($acao == 'editLiberacao') {
    if (isset($_GET['idLiberacao'])) {
      include_once('editLiberacao.php');
    } else {
      echo "ID da liberação não encontrado.";
    }
  } elseif ($acao == 'gerenciarMotivos') {
    include_once('gerenciarMotivos.php');
  } elseif ($acao == 'editOcorrenciaMotivo') {
    if (isset($_GET['idOcorrenciaMotivo'])) {
      include_once('editOcorrenciaMotivo.php');
    } else {
      echo "ID do motivo da ocorrência não encontrado.";
    }
  } elseif ($acao == 'editEventoMotivo') {
    if (isset($_GET['idEventoMotivo'])) {
      include_once('editEventoMotivo.php');
    } else {
      echo "ID do motivo de evento não encontrado.";
    }
  } elseif ($acao == 'cadOcorrenciaMotivo') {
    include_once('cadOcorrenciaMotivo.php');
  } elseif ($acao == 'cadEventoMotivo') {
    include_once('cadEventoMotivo.php');
  }
} else {
  header("Location: home.php?sisco=cadOcorrencia");
}
include_once("../include/footer.php");
