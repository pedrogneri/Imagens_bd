<?php
  include './php/Conexao.php';
  include './php/Usuario.php';

  session_start();
  if (isset($_SESSION["log"])) {
    header ("location:./paginas/pagina_usuario.php");
  }
  $logado = true;

  if (isset($_POST['logar'])) {
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    $usuario = new Usuario();
    $logado = $usuario->logar($login, sha1($senha));

    if($logado) {
      header("location:./paginas/pagina_usuario.php");
    }
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Projeto banco de dados</title>

    <link rel="stylesheet" type="text/css" href="./css/style.css">
  </head>
  <body class="center">
   <form style="margin-top: 20px" class="login" action="" method="POST">
     <div class="container">
       <label for="login"><b>Login</b></label>
       <input type="text" placeholder="Enter Username" name="login" required>
       <label for="senha"><b>Senha</b></label>
       <input type="password" placeholder="Enter Password" name="senha" required>
       <input type="SUBMIT"  class="button" name="logar">
    </form>
      <?php
        if(!$logado){
          echo "<p style='color:red;'> Login ou senha inválidos </p>";
        }
      ?>
      <p>Ainda não é cadastrado? <a href="./paginas/cadastro.php">Cadastrar-se</a></p>
    </div>
  </body>
</html>
