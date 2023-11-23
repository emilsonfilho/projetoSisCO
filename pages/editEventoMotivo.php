<?php
include_once('../config/conexao.php');
$id = $_GET['idEventoMotivo'];

try {
    /** QUERY MOTIVOS */
    $queryMotivo = "SELECT eventoMotivo_nome, eventoMotivo_descricao, tb_sisco_eventocategoria.eventoCategoria_nome, eventoMotivo_idCategoria FROM tb_sisco_eventomotivo JOIN tb_sisco_eventocategoria ON tb_sisco_eventomotivo.eventoMotivo_idCategoria = tb_sisco_eventocategoria.eventoCategoria_id WHERE eventoMotivo_id = :id";
    $stmtMotivo = $conexao->prepare($queryMotivo);
    $stmtMotivo->bindParam(':id', $id, PDO::PARAM_INT);
    $stmtMotivo->execute();

    $motivo = $stmtMotivo->fetch(PDO::FETCH_ASSOC);

    /** QUERY CATEGORIAS */
    $queryCategorias = "SELECT eventoCategoria_id, eventoCategoria_nome FROM tb_sisco_eventocategoria";
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
                    <h5 class="card-title">Editar Motivo de Evento</h5>
                    <form action="../operations/updateEventoMotivo.php?idEventoMotivo=<?php echo $id; ?>" method="post">
                        <div class="mb-3">
                            <label for="inputNomeMotivo" class="form-label">Nome do motivo</label>
                            <input type="text" id="inputNomeMotivo" name="eventoMotivo_nome" class="form-control" placeholder="Informe o nome do motivo" required value="<?php echo $motivo['eventoMotivo_nome'] ?>">
                        </div>
                        <div class="mb-3">
                            <label for="descricao">Descrição do motivo</label>
                            <textarea name="eventoMotivo_descricao" id="descricao" class="form-control" required><?php echo $motivo['eventoMotivo_descricao'] ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="categoria">Categoria do motivo</label>
                            <select name="eventoMotivo_idCategoria" id="categoria" class="form-select" required>
                                <?php
                                foreach ($categorias as $categoria) {
                                ?>
                                    <option value="<?php echo $categoria['eventoCategoria_id']; ?>" <?php echo ($categoria['eventoCategoria_id'] == $motivo['eventoMotivo_idCategoria']) ? 'selected' : ''; ?>><?php echo $categoria['eventoCategoria_nome'] ?></option>
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