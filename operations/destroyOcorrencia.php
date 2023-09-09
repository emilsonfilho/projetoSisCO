<?php
session_start();
include_once('../config/conexao.php');

if (!isset($_SESSION['loginuser'])) {
    echo "Sessão inválida";
    exit;
}

$id = $_POST['idOcorrencia'];

try {
    $selectDiscenteId = "SELECT tb_jmf_discente.discente_matricula FROM tb_sisco_ocorrencia JOIN tb_jmf_discente ON tb_sisco_ocorrencia.ocorrencia_idDiscente = tb_jmf_discente.discente_matricula WHERE tb_sisco_ocorrencia.ocorrencia_id = :id;";
    $stmt = $conexao->prepare($selectDiscenteId);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $discenteId = $result['discente_matricula'];

        $deleteOcorrencia = "DELETE FROM tb_sisco_ocorrencia WHERE ocorrencia_id = :id";

        try {
            $stmtDelete = $conexao->prepare($deleteOcorrencia);
            $stmtDelete->bindValue(':id', $id, PDO::PARAM_INT);
            $stmtDelete->execute();

            $rowCount = $stmtDelete->rowCount();

            if ($rowCount > 0) {
                $msgType = urlencode("success");
                $msg = urlencode("Ocorrência deletada com sucesso!");
                header("Location: ../pages/home.php?sisco=detalhesDiscente&matricula=$discenteId&msgType=$msgType&msg=$msg");
            } else {
                $msgType = urlencode("error");
                $msg = urlencode("Falha ao deletar a ocorrência.");
                header("Location: ../pages/home.php?sisco=detalhesDiscente&matricula=$discenteId&msgType=$msgType&msg=$msg");
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    } else {
        $msgType = urlencode("error");
        $msg = urlencode("Matrícula do discente não encontrada.");
        header("Location: ../pages/home.php?sisco=cadOcorrencia$discenteId&msgType=$msgType&msg=$msg");

    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
