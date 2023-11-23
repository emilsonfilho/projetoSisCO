<?php

session_start();
include_once('../config/conexao.php');

if (!isset($_SESSION['loginuser'])) {
    echo "Sessão inválida";
    exit;
}

$id = $_POST['idOcorrenciaMotivo'];

$queryCheckOcorrencias = "SELECT COUNT(*) FROM tb_sisco_ocorrencia WHERE ocorrencia_idMotivo = :id";

try {
    $stmtCheck = $conexao->prepare($queryCheckOcorrencias);
    $stmtCheck->bindValue(':id', $id, PDO::PARAM_INT);
    $stmtCheck->execute();

    $rowCount = $stmtCheck->fetchColumn();

    if ($rowCount > 0) {
        echo "<script>
                var userConfirmed = confirm('Existem ocorrências associadas a este motivo. Deseja excluir as ocorrências junto com o motivo?');
                if (userConfirmed) {
                    window.location.href = 'destroyOcorrenciaMotivo.php?id=$id&deleteOcorrencias=true';
                } else {
                    window.location.href = '../pages/home.php?sisco=gerenciarMotivos';
                }
              </script>";
    } else {
        // Se não houver ocorrências, prosseguir com a exclusão normalmente
        header("Location: destroyOcorrenciaMotivo.php?id=$id");
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
