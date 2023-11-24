<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card shadow-sm rounded">
        <div class="card-body">
          <h5 class="card-title">Relatório de Turmas</h5>
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Turma</th>
                  <th class="text-center">Ações</th>
                </tr>
              </thead>
              <tbody>
                <?php
                include_once('../config/conexao.php');
                $turmasSelect = "SELECT tb_jmf_turma.turma_id, tb_jmf_turma.turma_serie, tb_jmf_curso.curso_nome
                   FROM tb_jmf_turma
                   JOIN tb_jmf_curso ON tb_jmf_turma.turma_idCurso = tb_jmf_curso.curso_id
                   ORDER BY tb_jmf_turma.turma_serie ASC, tb_jmf_curso.curso_nome ASC";
                try {
                  $stmtTurmas = $conexao->prepare($turmasSelect);
                  $stmtTurmas->execute();
                  $turmas = $stmtTurmas->fetchAll(PDO::FETCH_ASSOC);
                  foreach ($turmas as $turma) {
                    $turmaId = $turma['turma_id'];
                    $turmaNome = $turma['turma_serie'] . " - " . $turma['curso_nome'];
                    // Gera a URL para o relatório individual da turma
                    $urlRelatorio = "home.php?sisco=relatorioIndividual&idTurma=" . $turmaId;
                ?>
                    <tr>
                      <td><?php echo $turmaNome; ?></td>
                      <td class="text-center">
                        <a href="<?php echo $urlRelatorio; ?>" class="btn btn-primary"><i class="fas fa-file-alt me-1"></i> Ver Relatório</a>
                      </td>
                    </tr>
                <?php
                  }
                } catch (PDOException $e) {
                  echo "<b>Erro: </b>" . $e->getMessage();
                }
                ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>