<?php
include_once('../config/conexao.php');
$id = $_GET['idOcorrenciaMotivo'];

try {
    /** QUERY MOTIVOS */
    $queryMotivo = "SELECT ocorrenciaMotivo_nome, ocorrenciaMotivo_descricao, tb_sisco_ocorrenciacategoria.ocorrenciaCategoria_nome, ocorrenciaMotivo_idCategoria FROM tb_sisco_ocorrenciamotivo JOIN tb_sisco_ocorrenciacategoria ON tb_sisco_ocorrenciamotivo.ocorrenciaMotivo_idCategoria = tb_sisco_ocorrenciacategoria.ocorrenciaCategoria_id WHERE ocorrenciaMotivo_id = :id";
    $stmtMotivo = $conexao->prepare($queryMotivo);
    $stmtMotivo->bindParam(':id', $id, PDO::PARAM_INT);
    $stmtMotivo->execute();

    $motivo = $stmtMotivo->fetch(PDO::FETCH_ASSOC);

    /** QUERY CATEGORIAS */
    $queryCategorias = "SELECT ocorrenciaCategoria_id, ocorrenciaCategoria_nome FROM tb_sisco_ocorrenciacategoria";
    $stmtCategorias = $conexao->prepare($queryCategorias);
    $stmtCategorias->execute();

    $categorias = $stmtCategorias->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo $e->getMessage();
}

?>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm rounded">
                <div class="card-body">
                    <h5 class="card-title">Editar Motivo de Ocorrência</h5>
                    <form action="../operations/updateOcorrenciaMotivo.php?idOcorrenciaMotivo=<?php echo $id; ?>" method="post">
                        <div class="mb-3">
                            <label for="inputNomeMotivo" class="form-label">Nome do motivo</label>
                            <input type="text" id="inputNomeMotivo" name="ocorrenciaMotivo_nome" class="form-control" placeholder="Informe o nome do motivo" required value="<?php echo $motivo['ocorrenciaMotivo_nome'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="descricao">Descrição do motivo</label>
                            <textarea name="ocorrenciaMotivo_descricao" id="descricao" class="form-control"><?php echo $motivo['ocorrenciaMotivo_descricao'] ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="categoria">Categoria do motivo</label>
                            <select name="ocorrenciaMotivo_idCategoria" id="categoria" class="form-select">
                                <?php
                                foreach ($categorias as $categoria) {
                                ?>
                                    <option value="<?php echo $categoria['ocorrenciaCategoria_id']; ?>" <?php echo ($categoria['ocorrenciaCategoria_id'] == $motivo['ocorrenciaMotivo_idCategoria']) ? 'selected' : ''; ?>><?php echo $categoria['ocorrenciaCategoria_nome'] ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <!-- <a href="#" class="btn btn-primary">Editar</a> -->
                            <input type="submit" value="Concluir" class="btn btn-primary">
                            <a href="javascript:history.back()" class="btn btn-secondary">Voltar</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>