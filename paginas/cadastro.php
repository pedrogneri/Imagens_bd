<?php
  include '../php/Conexao.php';
  include '../php/Usuario.php';
  $usuarioValido = true;
  $senhasCorretas = true;

  $usuario = new Usuario();

  if(isset($_POST['cadastrar'])){
    $nome = $_POST['nome'];
    $login = $_POST['usuario'];
    $senha = sha1($_POST['senha']);
    $senha2 = sha1($_POST['senha2']);

    $imagem = $_FILES['imagem'];

    $senhasCorretas = $senha == $senha2;
    $usuarioValido = $usuario->conferirUsuario($login);

    if($usuarioValido && $senhasCorretas){
      $usuario->salvar($nome, $login, $senha, $imagem);
      header("location:../index.php");
    }
  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Projeto banco de dados</title>

    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <script type="text/javascript" src="../js/script.js"></script>
  </head>
  <body>
    <form style="margin-top: 20px" class="login" action="" method="POST" enctype="multipart/form-data">
      <div style="text-align: center;" class="imgcontainer">
        <br>
        <label for="imagem">Selecione seu avatar (png ou jpg)</label>
        <br>
        <input type="file" name="imagem" id="imagem" file-accept="jpg png" onchange="loadFile(event)">
        <br><br>
        <img id="output" width="100" src="../img/user.png" alt="Avatar" class="avatar">
        <br>
       </div>

       <div class="container">
         <label>Nome</label>
         <br>
         <input type="TEXT" placeholder="Insira um nome" name="nome" required>
         <br>
         <label>Login</label>
         <br>
         <input type="TEXT" placeholder="Insira um usuario" name="usuario" required>
         <br>
         <label>Senha</label>
         <br>
         <input type="PASSWORD" placeholder="Insira uma senha" name="senha" required>
         <br>
         <label>Confirme sua senha</label>
         <br>
         <input type="PASSWORD" placeholder="Insira novamente a senha" name="senha2" required>
         <br>
         <input type="SUBMIT" value="Cadastrar" class="button" name="cadastrar">
         <?php
           if(!$usuarioValido){
             echo "<p style='color:red;'>Usuario existente!</p>";
           } else if(!$senhasCorretas){
             echo "<p style='color:red;'>Senha incorreta!</p>";
           }
         ?>
       </div>
       <div class="container" style="background-color:#f1f1f1">
         <button style="color:white;" type="button" class="btnCancelar" onclick="btnCancelar()">Cancelar</button>
      </div>
    </form>
  </body>
</html>
