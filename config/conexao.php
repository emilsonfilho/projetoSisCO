<?php
try {
    define('HOST', 'localhost');
    define('DB', 'bd_jmf');
    define('USER', 'root');
    define('PASS', 'bdjmf');
    $conexao = new PDO('mysql:host='.HOST.';dbname='.DB,USER,PASS);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "<b>ERRO : </b>".$e->getMessage();
    
}