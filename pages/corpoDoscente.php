<?php
include('../config/conexao.php');

$colaboradoresSelect = "SELECT tb_jmf_colaborador.colaborador_nome, tb_jmf_funcao.funcao_nome, tb_jmf_colaborador.colaborador_telefone
                        FROM tb_jmf_colaborador
                        INNER JOIN tb_jmf_funcao ON tb_jmf_colaborador.colaborador_idFuncao = tb_jmf_funcao.funcao_id";

try {
    $resultColaboradores = $conexao->prepare($colaboradoresSelect);
    $resultColaboradores->execute();

    $colaboradores = $resultColaboradores->fetchAll(PDO::FETCH_OBJ);
} catch (PDOException $e) {
    echo "<b>Erro: </b>" . $e->getMessage();
}
?>

<div class="container">
    <?php
    // Verificar se a mensagem está presente na URL
    if (isset($_GET['msgType']) && isset($_GET['msg'])) {
        $msgType = $_GET['msgType'];
        $msg = $_GET['msg'];

        // Verificar o tipo de mensagem e exibir a mensagem correspondente
        if ($msgType === 'success') {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            echo urldecode($msg);
            echo '</div>';
        } elseif ($msgType === 'error') {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
            echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
            echo urldecode($msg);
            echo '</div>';
        }
    }
    ?>
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <div class="card shadow-sm rounded">
                <div class="card-body">
                    <h5 class="card-title">Corpo Docente</h5>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Função</th>
                                    <th>Telefone</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($colaboradores as $colaborador) : ?>
                                    <tr>
                                        <td><?php echo $colaborador->colaborador_nome; ?></td>
                                        <td><?php echo $colaborador->funcao_nome; ?></td>
                                        <td><?php echo $colaborador->colaborador_telefone; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>