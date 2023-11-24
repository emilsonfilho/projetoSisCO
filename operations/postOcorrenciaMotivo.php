<?php
session_start();
include('../config/conexao.php');
require_once('../utils/agora.php');

if (!isset($_SESSION['loginuser'])) {
    echo "Sessão inválida";
    exit;
}

$ocorrenciaMotivo_nome = $_POST['ocorrenciaMotivo_nome'];
$ocorrenciaMotivo_descricao = $_POST['ocorrenciaMotivo_descricao'];
$ocorrenciaMotivo_idCategoria = $_POST['ocorrenciaMotivo_idCategoria'];

$query = "INSERT INTO tb_sisco_ocorrenciamotivo (
    ocorrenciaMotivo_idCategoria,
    ocorrenciaMotivo_nome,
    ocorrenciaMotivo_descricao
) VALUES (
    :idCategoria,
    :nome,
    :descricao
)";

try {
    $stmt = $conexao->prepare($query);
    $stmt->bindValue(':idCategoria', $ocorrenciaMotivo_idCategoria);
    $stmt->bindValue(':nome', $ocorrenciaMotivo_nome);
    $stmt->bindValue(':descricao', $ocorrenciaMotivo_descricao);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $msgType = urlencode("success");
        $msg = urlencode("Motivo de ocorrência registrado com sucesso!");
        header("Location: ../pages/home.php?sisco=gerenciarMotivos&msgType=$msgType&msg=$msg");
    } else {
        $msgType = urlencode("error");
        $msg = urlencode("Ocorreu algum erro ao tentar registrar o motivo de ocorrência.");
        header("Location: ../pages/home.php?sisco=gerenciarMotivos&msgType=$msgType&msg=$msg");
    }
} catch (\Throwable $th) {
    //throw $th;
}