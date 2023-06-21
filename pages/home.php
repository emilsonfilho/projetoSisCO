<?php
    include_once("../include/header.php");
    if (isset($_GET['sisco'])) {
      $acao = $_GET['sisco'];
      if ($acao == 'cadOcorrencia') {
        include_once('cadOcorrencia.php');
      }
    }
    if(isset($_GET['saep'])){
        $acao= $_GET['saep']; //Pega o parametro que está sendo passado pela página
        #Páginas do usuário Seleção
        if($acao == 'cadAluno'){
            include_once('cadAluno.php');
          }elseif ($acao == 'lista'){
            include_once('lista.php');
          }elseif ($acao == 'perfil'){
            include_once('perfil.php');
          }
          #Páginas do usuário Admin
          elseif ($acao == 'painel'){
            include_once('painel.php');
          }elseif ($acao == 'usuarios'){
            include_once('usuarios.php');
          }elseif ($acao == 'cursos'){
            include_once('cursos.php');
          }elseif ($acao == 'regras'){
            include_once('regras.php');
          }elseif ($acao == 'perfil'){
            include_once('perfil.php');
            #Ações de Delete
          }elseif ($acao == 'deleteSelecao'){
            include_once('deleteSelecao.php');
          }elseif ($acao == 'delUser'){
            include_once('delUser.php');
          }elseif ($acao == 'upUser'){
            include_once('upUser.php');
          }elseif ($acao == 'upCursoSelecao'){
            include_once('upCursosSelecao.php');
          }elseif ($acao == 'upCurso'){
            include_once('upCursos.php');
          } else if ($acao == 'cadOcorrencia.php') {
            include_once('cadOcorrencia.php');
          }
    }else{
        //include_once("painel.php");
    }
    include_once("../include/footer.php");