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
        $msg = urlencode("E-mail não encontrado no banco de dados.");
        header("Location: ../pages/home.php?sisco=cadOcorrencia&msgType=$msgType&msg=$msg");
        exit;
    }

    $idColaborador = $row['colaborador_matricula'];
} catch (PDOException $e) {
    $msgType = urlencode("error");
    $msg = urlencode("Ocorreu algum erro ao tentar registrar a ocorrência.");
    header("Location: ../pages/home.php?sisco=cadOcorrencia&msgType=$msgType&msg=$msg");
}


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ocorrencia_idDiscente = $_POST['discente_matricula'];
    $ocorrencia_idColaborador = $idColaborador;

    // Esse select teve que ficar aqui porque ele depende de um valor que é o id do discente
    $selectResponsavelLegal = "SELECT discente_idResponsavel FROM tb_jmf_discente WHERE discente_matricula = :matricula";

    try {
        $stmtResponsavelLegal = $conexao->prepare($selectResponsavelLegal);
        $stmtResponsavelLegal->bindValue(':matricula', $ocorrencia_idDiscente);
        $stmtResponsavelLegal->execute();
        $rowResponsavelLegal = $stmtResponsavelLegal->fetch(PDO::FETCH_ASSOC);

        if ($rowResponsavelLegal === false) {
            $msgType = urlencode("error");
            $msg = urlencode("Responsável legal não encontrado no banco de dados.");
            header("Location: ../pages/home.php?sisco=cadOcorrencia&msgType=$msgType&msg=$msg");
            exit;
        }

        $ocorrencia_idResponsavelLegal = $rowResponsavelLegal['discente_idResponsavel'];
    } catch (PDOException $e) {
        $msgType = urlencode("error");
        $msg = urlencode("Ocorreu algum erro ao tentar registrar a ocorrência.");
        header("Location: ../pages/home.php?sisco=cadOcorrencia&msgType=$msgType&msg=$msg");
    }

    // Outro select para pegar a categoria correspondente
    $ocorrencia_idMotivo = $_POST['ocorrencia_idMotivo'];

    $selectCategoria = "SELECT ocorrenciaMotivo_idCategoria FROM tb_sisco_ocorrenciamotivo WHERE ocorrenciaMotivo_id = :idMotivo";

    try {
        $stmtCategoria = $conexao->prepare($selectCategoria);
        $stmtCategoria->bindValue(':idMotivo', $ocorrencia_idMotivo);
        $stmtCategoria->execute();
        $rowCategoria = $stmtCategoria->fetch(PDO::FETCH_ASSOC);

        if ($rowCategoria === false) {
            $msgType = urlencode("error");
            $msg = urlencode("Categoria não encontrada no banco de dados");
            header("Location: ../pages/home.php?sisco=cadOcorrencia&msgType=$msgType&msg=$msg");
            exit;
        }

        $ocorrencia_idCategoria = $rowCategoria['ocorrenciaMotivo_idCategoria'];
    } catch (PDOException $e) {
        $msgType = urlencode("error");
        $msg = urlencode("Ocorreu algum erro ao tentar registrar a ocorrência.");
        header("Location: ../pages/home.php?sisco=cadOcorrencia&msgType=$msgType&msg=$msg");
    }

    $ocorrencia_data = $_POST['ocorrencia_data'];
    $ocorrencia_hora = $_POST['ocorrencia_hora'];
    $ocorrencia_descricao = $_POST['ocorrencia_descricao'];
    $ocorrencia_dataTime = date('Y-m-d H:i:s');

    try {
        // Preparar a consulta SQL para inserir os dados na tabela de ocorrências
        $inserirOcorrencia = "INSERT INTO tb_sisco_ocorrencia (ocorrencia_idDiscente, ocorrencia_idColaborador, ocorrencia_idResponsavelLegal, ocorrencia_idCategoria, ocorrencia_idMotivo, ocorrencia_data, ocorrencia_hora, ocorrencia_descricao, ocorrencia_dataTime)
                              VALUES (:idDiscente, :idColaborador, :idResponsavelLegal, :idCategoria, :idMotivo, :data, :hora, :descricao, :dataTime)";

        // Preparar a declaração
        $stmtInserirOcorrencia = $conexao->prepare($inserirOcorrencia);

        // Vincular os valores aos parâmetros da consulta
        $stmtInserirOcorrencia->bindValue(':idDiscente', $ocorrencia_idDiscente);
        $stmtInserirOcorrencia->bindValue(':idColaborador', $ocorrencia_idColaborador);
        $stmtInserirOcorrencia->bindValue(':idResponsavelLegal', $ocorrencia_idResponsavelLegal);
        $stmtInserirOcorrencia->bindValue(':idMotivo', $ocorrencia_idMotivo);
        $stmtInserirOcorrencia->bindValue(':idCategoria', $ocorrencia_idCategoria);
        $stmtInserirOcorrencia->bindValue(':data', $ocorrencia_data);
        $stmtInserirOcorrencia->bindValue(':hora', $ocorrencia_hora);
        $stmtInserirOcorrencia->bindValue(':descricao', $ocorrencia_descricao);
        $stmtInserirOcorrencia->bindValue(':dataTime', $ocorrencia_dataTime);

        // Executar a consulta
        $stmtInserirOcorrencia->execute();

        // Verificar se a inserção foi bem-sucedida
        if ($stmtInserirOcorrencia->rowCount() > 0) {
            $msgType = urlencode("success");
            $msg = urlencode("Ocorrência registrada com sucesso!");
            header("Location: ../pages/home.php?sisco=cadOcorrencia&msgType=$msgType&msg=$msg");
        } else {
            $msgType = urlencode("error");
            $msg = urlencode("Ocorreu algum erro ao tentar registrar a ocorrência.");
            header("Location: ../pages/home.php?sisco=cadOcorrencia&msgType=$msgType&msg=$msg");
        }
    } catch (PDOException $e) {
        echo "<strong>Error:</strong> " . $e->getMessage();
    }
}
