<?php
include_once("../config/conexao.php");

if (isset($_GET['idTurma'])) {
  $idTurma = $_GET['idTurma'];

  // Consulta para obter as informações da turma
  $turmaQuery = "SELECT tb_jmf_turma.turma_id, tb_jmf_turma.turma_serie, tb_jmf_curso.curso_nome
                FROM tb_jmf_turma
                INNER JOIN tb_jmf_curso ON tb_jmf_turma.turma_idCurso = tb_jmf_curso.curso_id
                WHERE tb_jmf_turma.turma_id = :idTurma";

  try {
    $stmtTurma = $conexao->prepare($turmaQuery);
    $stmtTurma->bindParam(':idTurma', $idTurma);
    $stmtTurma->execute();
    $turma = $stmtTurma->fetch(PDO::FETCH_ASSOC);

    if ($turma) {
      $turmaId = $turma['turma_id'];
      $serieTurma = $turma['turma_serie'];
      $cursoNome = $turma['curso_nome'];

      $alunosQuery = "SELECT tb_jmf_discente.discente_nome, tb_jmf_discente.discente_matricula,
    (SELECT COUNT(*) FROM tb_sisco_ocorrencia WHERE tb_sisco_ocorrencia.ocorrencia_idDiscente = tb_jmf_discente.discente_matricula) AS total_ocorrencias,
    (SELECT COUNT(*) FROM tb_sisco_evento WHERE tb_sisco_evento.evento_idDiscente = tb_jmf_discente.discente_matricula) AS total_eventos,
    (SELECT COUNT(*) FROM tb_sisco_liberacao WHERE tb_sisco_liberacao.liberacao_idDiscente = tb_jmf_discente.discente_matricula) AS total_liberacoes
    FROM tb_jmf_discente
    WHERE tb_jmf_discente.discente_idTurma = :idTurma
    ORDER BY tb_jmf_discente.discente_nome ASC";

      $stmtAlunos = $conexao->prepare($alunosQuery);
      $stmtAlunos->bindParam(':idTurma', $idTurma);
      $stmtAlunos->execute();
      $alunos = $stmtAlunos->fetchAll(PDO::FETCH_ASSOC);

      // Contagem total de alunos, ocorrências e eventos da turma
      $totalAlunos = count($alunos);
      $totalOcorrenciasTurma = 0;
      $totalEventosTurma = 0;
      $totalLiberacoesTurma = 0;

      foreach ($alunos as $aluno) {
        $totalOcorrenciasTurma += $aluno['total_ocorrencias'];
        $totalEventosTurma += $aluno['total_eventos'];
        $totalLiberacoesTurma += $aluno['total_liberacoes'];
      }
    }
  } catch (PDOException $e) {
    echo "<b>Erro: </b>" . $e->getMessage();
  }
}
?>
<style>

</style>
<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-12">
      <div class="card shadow-sm rounded">
        <div class="card-body">
          <div class="card-title d-flex justify-content-between align-items-center">
            <h5>Exibindo relatório de <?php echo $serieTurma; ?> - <?php echo $cursoNome; ?></h5>
            <a href="javascript:history.back()" class="btn btn-primary d-inline">Voltar</a>
          </div>
          <!-- <h5 class="card-title">Exibindo relatório de <?php echo $serieTurma; ?> - <?php echo $cursoNome; ?></h5> -->
          <div class="table-responsive">
            <table class="table">
              <thead>
                <tr>
                  <th>Nome</th>
                  <th class="text-center">Nº Matrícula</th>
                  <th class="text-center">Qntd. Ocorrências</th>
                  <th class="text-center">Qntd. Eventos</th>
                  <th class="text-center">Qntd. Liberações</th>
                  <th class="text-center">Consulta</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($alunos as $aluno) : ?>
                  <tr>
                    <td><?php echo $aluno['discente_nome']; ?></td>
                    <td class="text-center"><?php echo $aluno['discente_matricula']; ?></td>
                    <td class="text-center"><?php echo $aluno['total_ocorrencias']; ?></td>
                    <td class="text-center"><?php echo $aluno['total_eventos']; ?></td>
                    <td class="text-center"><?php echo $aluno['total_liberacoes']; ?></td>
                    <td class="text-center">
                      <a href="home.php?sisco=detalhesDiscente&matricula=<?php echo $aluno['discente_matricula']; ?>" class="btn btn-info btn-sm">Detalhes</a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
          <p class="text-muted">Quantidade total de alunos: <?php echo $totalAlunos; ?></p>
          <p class="text-muted">Quantidade total de ocorrências: <?php echo $totalOcorrenciasTurma; ?></p>
          <p class="text-muted">Quantidade total de eventos: <?php echo $totalEventosTurma; ?></p>
          <p class="text-muted">Quantidade total de liberações: <?php echo $totalLiberacoesTurma; ?></p>
        </div>
      </div>
    </div>
  </div>
</div>