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
    $evento_id = $_GET['idEvento'];
    $evento_idDiscente = $_POST['discente_matricula'];
    $evento_idColaborador = $idColaborador;

    $selectResponsavelLegal = "SELECT discente_idResponsavel FROM tb_jmf_discente WHERE discente_matricula = :matricula";

    try {
        $stmtResponsavelLegal = $conexao->prepare($selectResponsavelLegal);
        $stmtResponsavelLegal->bindValue(':matricula', $evento_idDiscente);
        $stmtResponsavelLegal->execute();
        $rowResponsavelLegal = $stmtResponsavelLegal->fetch(PDO::FETCH_ASSOC);

        if ($rowResponsavelLegal === false) {
            echo "Responsável legal não encontrado no banco de dados";
            exit;
        }

        $evento_idResponsavel = $rowResponsavelLegal['discente_idResponsavel'];
    } catch (PDOException $e) {
        echo "<strong>Error:</strong>" . $e->getMessage();
    }

    // Outro select para pegar a categoria correspondente
    $evento_idMotivo = $_POST['evento_idMotivo'];

    $selectCategoria = "SELECT eventoMotivo_idCategoria FROM tb_sisco_eventomotivo WHERE eventoMotivo_id = :idMotivo";

    try {
        $stmtCategoria = $conexao->prepare($selectCategoria);
        $stmtCategoria->bindValue(':idMotivo', $evento_idMotivo);
        $stmtCategoria->execute();
        $rowCategoria = $stmtCategoria->fetch(PDO::FETCH_ASSOC);

        if ($rowCategoria === false) {
            echo "Categoria não encontrada no banco de dados";
            exit;
        }

        $evento_idCategoria = $rowCategoria['eventoMotivo_idCategoria'];
    } catch (PDOException $e) {
        echo "<strong>Error:</strong>" . $e->getMessage();
    }

    $evento_data = $_POST['evento_data'];
    $evento_hora = $_POST['evento_hora'];
    $evento_observacao = $_POST['evento_observacao'];
    $evento_dateTime = date('Y-m-d H:i:s');

    try {
        $update = "UPDATE tb_sisco_evento SET evento_idDiscente = :idDiscente, evento_idColaborador = :idColaborador, evento_idResponsavel = :idResponsavelLegal, evento_idCategoria = :idCategoria, evento_idMotivo = :idMotivo, evento_data = :data, evento_hora = :hora, evento_observacao = :observacao, evento_dateTime = :dateTime WHERE evento_id = :id";

        $stmtUpdate = $conexao->prepare($update);
        $stmtUpdate->bindValue(':idDiscente', $evento_idDiscente);
        $stmtUpdate->bindValue(':idColaborador', $evento_idColaborador);
        $stmtUpdate->bindValue(':idResponsavelLegal', $evento_idResponsavel);
        $stmtUpdate->bindValue(':idCategoria', $evento_idCategoria);
        $stmtUpdate->bindValue(':idMotivo', $evento_idMotivo);
        $stmtUpdate->bindValue(':data', $evento_data);
        $stmtUpdate->bindValue(':hora', $evento_hora);
        $stmtUpdate->bindValue(':observacao', $evento_observacao);
        $stmtUpdate->bindValue(':dateTime', $evento_dateTime);
        $stmtUpdate->bindValue(':id', $evento_id);

        $stmtUpdate->execute();

        if ($stmt->rowCount() > 0) {
            $msgType = urlencode("success");
            $msg = urlencode("Evento atualizado com sucesso.");
            header("Location: ../pages/home.php?sisco=detalhesDiscente&matricula=$evento_idDiscente&msgType=$msgType&msg=$msg");
        } else {
            $msgType = urlencode("error");
            $msg = urlencode("Falha ao atualizar o evento.");
            header("Location: ../pages/home.php?sisco=detalhesDiscente&matricula=$evento_idDiscente&msgType=$msgType&msg=$msg");
        }
    } catch (PDOException $e) {
        echo "<strong>Error:</strong>" . $e->getMessage();
    }
}