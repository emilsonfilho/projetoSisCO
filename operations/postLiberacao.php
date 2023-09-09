<?php
session_start();
include('../config/conexao.php');

if (!isset($_SESSION['loginuser'])) {
    echo "Sessão inválida";
    exit;
}

$emailLogado = $_SESSION['loginuser'];

$consultaIdPessoa = "SELECT colaborador_matricula FROM tb_jmf_colaborador WHERE colaborador_email = :email";

try {
    $stmt = $conexao->prepare($consultaIdPessoa);
    $stmt->bindValue(':email', $emailLogado);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row === false) {
        $msgType = urlencode("error");
        $msg = urlencode("Email não encontrado no banco de dados.");
        header("Location: ../pages/home.php?sisco=liberacao&msgType=$msgType&msg=$msg");
        exit;
    }

    $idColaborador = $row['colaborador_matricula'];
} catch (PDOException $e) {
    $msgType = urlencode("error");
    $msg = urlencode("Ocorreu algum erro ao tentar registrar a liberção.");
    header("Location: ../pages/home.php?sisco=liberacao&msgType=$msgType&msg=$msg");
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $liberacao_idDiscente = $_POST['discente_matricula'];
    $liberacao_idColaborador = $idColaborador;

    // Esse select teve que ficar aqui porque ele depende de um valor que é o id do discente
    $selectResponsavel = "SELECT discente_idResponsavel FROM tb_jmf_discente WHERE discente_matricula = :matricula";

    try {
        $stmtResponsavel = $conexao->prepare($selectResponsavel);
        $stmtResponsavel->bindValue(':matricula', $liberacao_idDiscente);
        $stmtResponsavel->execute();
        $rowResponsavel = $stmtResponsavel->fetch(PDO::FETCH_ASSOC);

        if ($rowResponsavel === false) {
            echo "Responsável legal não encontrado no banco de dados";
            exit;
        }

        $liberacao_idResponsavel = $rowResponsavel['discente_idResponsavel'];
    } catch (PDOException $e) {
        // echo "<strong>Error:</strong>" . $e->getMessage();
        $msgType = urlencode("error");
        $msg = urlencode("Ocorreu algum erro ao tentar registrar a liberção.");
        header("Location: ../pages/home.php?sisco=liberacao&msgType=$msgType&msg=$msg");
    }

    $liberacao_tipo = $_POST['tipoLiberacao'];
    $liberacao_dateTime = date('Y-m-d H:i:s');

    $liberacao_data = $_POST['liberacao_dt'];
    $liberacao_hora = $_POST['liberacao_hr'];

    if ($liberacao_tipo == 'retorno') {
        $colunaData = 'liberacao_dtRetorno';
        $colunaHora = 'liberacao_hrRetorno';
    } else {
        $colunaData = 'liberacao_dtSaida';
        $colunaHora = 'liberacao_hrSaida';
    }

    $liberacao_observacao = $_POST['liberacao_observacao'];

    try {
        // Preparar a consulta SQL para inserir os dados na tabela de ocorrências
        $inserirliberacao = "INSERT INTO tb_sisco_liberacao (liberacao_idDiscente, liberacao_idColaboradorSaida, liberacao_idResponsavel, $colunaData, $colunaHora, liberacao_observacao, liberacao_dateTime)
                              VALUES (:idDiscente, :idColaboradorSaida, :idResponsavel, :dt, :hr, :observacao, :dateTime)";

        // Preparar a declaração
        $stmtInserirliberacao = $conexao->prepare($inserirliberacao);

        // Vincular os valores aos parâmetros da consulta
        $stmtInserirliberacao->bindValue(':idDiscente', $liberacao_idDiscente);
        $stmtInserirliberacao->bindValue(':idColaboradorSaida', $liberacao_idColaborador);
        $stmtInserirliberacao->bindValue(':idResponsavel', $liberacao_idResponsavel);
        $stmtInserirliberacao->bindValue(':dt', $liberacao_data);
        $stmtInserirliberacao->bindValue(':hr', $liberacao_hora);
        $stmtInserirliberacao->bindValue(':observacao', $liberacao_observacao);
        $stmtInserirliberacao->bindValue(':dateTime', $liberacao_dateTime);

        // Executar a consulta
        $stmtInserirliberacao->execute();

        // Verificar se a inserção foi bem-sucedida
        if ($stmtInserirliberacao->rowCount() > 0) {
            $msgType = urlencode("success");
            $msg = urlencode("Liberação registrada com sucesso.");
            header("Location: ../pages/home.php?sisco=liberacao&msgType=$msgType&msg=$msg");
        } else {
            $msgType = urlencode("error");
            $msg = urlencode("Ocorreu um erro ao registrar a liberação.");
            header("Location: ../pages/home.php?sisco=liberacao&msgType=$msgType&msg=$msg");
        }
    } catch (PDOException $e) {
        echo "<strong>Error:</strong> " . $e->getMessage();
    }
}
