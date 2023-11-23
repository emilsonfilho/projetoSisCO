<?php

include('../config/conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eventoMotivo_id = $_GET['idEventoMotivo'];

    $idCategoria = $_POST['eventoMotivo_idCategoria'];

    $queryCategoria = "SELECT eventoCategoria_id FROM tb_sisco_eventocategoria WHERE eventoCategoria_id = :idCategoria";

    try {
        $stmtCategoria = $conexao->prepare($queryCategoria);
        $stmtCategoria->bindValue(':idCategoria', $idCategoria);
        $stmtCategoria->execute();
        $rowCategoria = $stmtCategoria->fetch(PDO::FETCH_ASSOC);

        if (!$rowCategoria) {
            echo "Categoria do evento não encontrado no banco de dados";
            exit;
        }

        $eventoMotivo_idCategoria = $rowCategoria['eventoCategoria_id'];
    } catch (PDOException $e) {
        echo "<strong>Error:</strong>" . $e->getMessage();
    }

    $eventoMotivo_nome = $_POST['eventoMotivo_nome'];
    $eventoMotivo_descricao = $_POST['eventoMotivo_descricao'];

    $updateMotivo = "UPDATE tb_sisco_eventomotivo SET eventoMotivo_idCategoria = :idCategoria, eventoMotivo_nome = :nome, eventoMotivo_descricao = :descricao WHERE eventoMotivo_id = :id";

    try {
        $stmtUpdate = $conexao->prepare($updateMotivo);
        $stmtUpdate->bindValue(':id', $eventoMotivo_id);
        $stmtUpdate->bindValue(':idCategoria', $eventoMotivo_idCategoria);
        $stmtUpdate->bindValue(':nome', $eventoMotivo_nome);
        $stmtUpdate->bindValue(':descricao', $eventoMotivo_descricao);

        $stmtUpdate->execute();

        if ($stmtUpdate->rowCount() > 0) {
            $msgType = urlencode("success");
            $msg = urlencode("Motivo de evento atualizado com sucesso");
            header("Location: ../pages/home.php?sisco=gerenciarMotivos&msgType=$msgType&msg=$msg");
        } else {
            echo "Falha ao tentar atualizar o motivo de ocorrência";

            $msgType = urlencode("error");
            $msg = urlencode("Falha ao atualiar o motivo de evento");
            header("Location: ../pages/home.php?sisco=gerenciarMotivos&msgType=$msgType&msg=$msg");
        }
    } catch (PDOException $e) {
        echo "<strong>Error:</strong>" . $e->getMessage();
    }
}