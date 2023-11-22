<?php
session_start();
include('../config/conexao.php');
require_once('../utils/agora.php');

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

    $idColaboradorUpdate = $row['colaborador_matricula'];
} catch (PDOException $e) {
    echo "<strong>Error:</strong>" . $e->getMessage();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $liberacao_id = $_GET['idLiberacao'];
    $liberacao_idDiscente = $_POST['discente_matricula'];

    $selectResponsavelLegal = "SELECT discente_idResponsavel FROM tb_jmf_discente WHERE discente_matricula = :matricula";

    try {
        $stmtResponsavelLegal = $conexao->prepare($selectResponsavelLegal);
        $stmtResponsavelLegal->bindValue(':matricula', $liberacao_idDiscente);
        $stmtResponsavelLegal->execute();
        $rowResponsavelLegal = $stmtResponsavelLegal->fetch(PDO::FETCH_ASSOC);

        if ($rowResponsavelLegal === false) {
            echo "Responsável legal não encontrado no banco de dados";
            exit;
        }

        $liberacao_idResponsavel = $rowResponsavelLegal['discente_idResponsavel'];
    } catch (PDOException $e) {
        echo "<strong>Error:</strong>" . $e->getMessage();
    }

    $liberacao_dtSaida = $_POST['liberacao_dtSaida'];
    $liberacao_hrSaida = $_POST['liberacao_hrSaida'];
    $liberacao_dtRetorno = $_POST['liberacao_dtRetorno'] !== '' ? $_POST['liberacao_dtRetorno'] : null;
    $liberacao_hrRetorno = $_POST['liberacao_hrRetorno'] !== '' ? $_POST['liberacao_hrRetorno'] : null;


    if ($liberacao_dtRetorno != null && $liberacao_hrRetorno != null) {
        $liberacao_idColaboradorRetorno = $idColaboradorUpdate;
    } else {
        $liberacao_idColaboradorRetorno = null;
    }

    $liberacao_observacao = $_POST['liberacao_observacao'];
    $liberacao_dataTime = agora();

    try {
        $selectIdColaboradorSaida = "SELECT liberacao_idColaboradorSaida FROM tb_sisco_liberacao WHERE liberacao_id = :idLiberacao";

        $stmtSelect = $conexao->prepare($selectIdColaboradorSaida);
        $stmtSelect->bindValue(':idLiberacao', $liberacao_id);
        $stmtSelect->execute();
        $idColaboradorSaida = $stmtSelect->fetch(PDO::FETCH_OBJ);

        $update = "UPDATE tb_sisco_liberacao SET liberacao_idDiscente = :idDiscente, liberacao_idResponsavel = :idResponsavelLegal, liberacao_dtSaida = :dtSaida, liberacao_hrSaida = :hrSaida, liberacao_idColaboradorSaida = :idColaboradorSaida, liberacao_dtRetorno = :dtRetorno, liberacao_hrRetorno = :hrRetorno, liberacao_idColaboradorRetorno = :idColaboradorRetorno, liberacao_observacao = :observacao, liberacao_dateTime = :dataTime WHERE liberacao_id = :id";

        $stmtUpdate = $conexao->prepare($update);
        $stmtUpdate->bindValue(':idDiscente', $liberacao_idDiscente);
        $stmtUpdate->bindValue(':idResponsavelLegal', $liberacao_idResponsavel);
        $stmtUpdate->bindValue(':dtSaida', $liberacao_dtSaida);
        $stmtUpdate->bindValue(':hrSaida', $liberacao_hrSaida);
        $stmtUpdate->bindValue(':idColaboradorSaida', $idColaboradorSaida->liberacao_idColaboradorSaida);
        $stmtUpdate->bindValue(':dtRetorno', $liberacao_dtRetorno);
        $stmtUpdate->bindValue(':hrRetorno', $liberacao_hrRetorno);
        $stmtUpdate->bindValue(':idColaboradorRetorno', $liberacao_idColaboradorRetorno);
        $stmtUpdate->bindValue(':observacao', $liberacao_observacao);
        $stmtUpdate->bindValue(':dataTime', $liberacao_dataTime);
        $stmtUpdate->bindValue(':id', $liberacao_id);

        $stmtUpdate->execute();

        if ($stmt->rowCount() > 0) {
            $msgType = urlencode("success");
            $msg = urlencode("Liberação editada com sucesso.");
            header("Location: ../pages/home.php?sisco=liberacao&msgType=$msgType&msg=$msg");
        } else {
            $msgType = urlencode("error");
            $msg = urlencode("Falha ao atualizar a liberação.");
            header("Location: ../pages/home.php?sisco=liberacao&msgType=$msgType&msg=$msg");
        }
    } catch (PDOException $e) {
        echo "<strong>Error:</strong>" . $e->getMessage();
    }
}
