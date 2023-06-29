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
        echo "E-mail não encontrado no banco de dados";
        exit;
    }

    $idColaborador = $row['colaborador_matricula'];
} catch (PDOException $e) {
    echo "<strong>Error:</strong>" . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ocorrencia_id = $_GET['idOcorrencia'];
    $ocorrencia_idDiscente = $_POST['discente_matricula'];
    $ocorrencia_idColaborador = $idColaborador;

    $selectResponsavelLegal = "SELECT discente_idResponsavel FROM tb_jmf_discente WHERE discente_matricula = :matricula";

    try {
        $stmtResponsavelLegal = $conexao->prepare($selectResponsavelLegal);
        $stmtResponsavelLegal->bindValue(':matricula', $ocorrencia_idDiscente);
        $stmtResponsavelLegal->execute();
        $rowResponsavelLegal = $stmtResponsavelLegal->fetch(PDO::FETCH_ASSOC);

        if ($rowResponsavelLegal === false) {
            echo "Responsável legal não encontrado no banco de dados";
            exit;
        }

        $ocorrencia_idResponsavelLegal = $rowResponsavelLegal['discente_idResponsavel'];
    } catch (PDOException $e) {
        echo "<strong>Error:</strong>" . $e->getMessage();
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
            echo "Categoria não encontrada no banco de dados";
            exit;
        }

        $ocorrencia_idCategoria = $rowCategoria['ocorrenciaMotivo_idCategoria'];
    } catch (PDOException $e) {
        echo "<strong>Error:</strong>" . $e->getMessage();
    }

    $ocorrencia_data = $_POST['ocorrencia_data'];
    $ocorrencia_hora = $_POST['ocorrencia_hora'];
    $ocorrencia_descricao = $_POST['ocorrencia_descricao'];
    $ocorrencia_dataTime = date('Y-m-d H:i:s');

    try {
        $update = "UPDATE tb_sisco_ocorrencia SET ocorrencia_idDiscente = :idDiscente, ocorrencia_idColaborador = :idColaborador, ocorrencia_idResponsavelLegal = :idResponsavelLegal, ocorrencia_idCategoria = :idCategoria, ocorrencia_idMotivo = :idMotivo, ocorrencia_data = :data, ocorrencia_hora = :hora, ocorrencia_descricao = :descricao, ocorrencia_dataTime = :dataTime WHERE ocorrencia_id = :id";

        $stmtUpdate = $conexao->prepare($update);
        $stmtUpdate->bindValue(':idDiscente', $ocorrencia_idDiscente);
        $stmtUpdate->bindValue(':idColaborador', $ocorrencia_idColaborador);
        $stmtUpdate->bindValue(':idResponsavelLegal', $ocorrencia_idResponsavelLegal);
        $stmtUpdate->bindValue(':idCategoria', $ocorrencia_idCategoria);
        $stmtUpdate->bindValue(':idMotivo', $ocorrencia_idMotivo);
        $stmtUpdate->bindValue(':data', $ocorrencia_data);
        $stmtUpdate->bindValue(':hora', $ocorrencia_hora);
        $stmtUpdate->bindValue(':descricao', $ocorrencia_descricao);
        $stmtUpdate->bindValue(':dataTime', $ocorrencia_dataTime);
        $stmtUpdate->bindValue(':id', $ocorrencia_id);

        $stmtUpdate->execute();

        if ($stmt->rowCount() > 0) {
            header("Location: home.php?sisco=detalhesDiscente&matricula=" . $ocorrencia_idDiscente);
        } else {
            echo "Falha ao atualizar a ocorrência";
        }
    } catch (PDOException $e) {
        echo "<strong>Error:</strong>" . $e->getMessage();
    }
}