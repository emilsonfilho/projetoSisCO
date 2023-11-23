<?php

include('../config/conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ocorrenciaMotivo_id = $_GET['idOcorrenciaMotivo'];

    $idCategoria = $_POST['ocorrenciaMotivo_idCategoria'];

    $queryCategoria = "SELECT ocorrenciaCategoria_id FROM tb_sisco_ocorrenciacategoria WHERE ocorrenciaCategoria_id = :idCategoria";

    try {
        $stmtCategoria = $conexao->prepare($queryCategoria);
        $stmtCategoria->bindValue(':idCategoria', $idCategoria);
        $stmtCategoria->execute();
        $rowCategoria = $stmtCategoria->fetch(PDO::FETCH_ASSOC);

        if (!$rowCategoria) {
            echo "Categoria da ocorrência não encontrada no banco de dados";
            exit;
        }

        $ocorrenciaMotivo_idCategoria = $rowCategoria['ocorrenciaCategoria_id'];
    } catch (PDOException $e) {
        echo "<strong>Error:</strong>" . $e->getMessage();
    }

    $ocorrenciaMotivo_nome = $_POST['ocorrenciaMotivo_nome'];
    $ocorrenciaMotivo_descricao = $_POST['ocorrenciaMotivo_descricao'];

    $updateMotivo = "UPDATE tb_sisco_ocorrenciamotivo SET ocorrenciaMotivo_idCategoria = :idCategoria, ocorrenciaMotivo_nome = :nome, ocorrenciaMotivo_descricao = :descricao WHERE ocorrenciaMotivo_id = :id";

    try {
        $stmtUpdate = $conexao->prepare($updateMotivo);
        $stmtUpdate->bindValue(':id', $ocorrenciaMotivo_id);
        $stmtUpdate->bindValue(':idCategoria', $ocorrenciaMotivo_idCategoria);
        $stmtUpdate->bindValue(':nome', $ocorrenciaMotivo_nome);
        $stmtUpdate->bindValue(':descricao', $ocorrenciaMotivo_descricao);

        $stmtUpdate->execute();

        if ($stmtUpdate->rowCount() > 0) {
            $msgType = urlencode("success");
            $msg = urlencode("Motivo de ocorrência atualizado com sucesso");
            header("Location: ../pages/home.php?sisco=gerenciarMotivos&msgType=$msgType&msg=$msg");
        } else {
            echo "Falha ao tentar atualizar o motivo de ocorrência";

            $msgType = urlencode("error");
            $msg = urlencode("Falha ao atualiar o motivo de ocorrência");
            header("Location: ../pages/home.php?sisco=gerenciarMotivos&msgType=$msgType&msg=$msg");
        }
    } catch (PDOException $e) {
        echo "<strong>Error:</strong>" . $e->getMessage();
    }
}
