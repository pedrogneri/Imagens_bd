<?php
  include '../php/Conexao.php';
  include '../php/Usuario.php';

  $usuarioValido = true;
  $senhasCorretas = true;

  $usuario = new Usuario();

  $id = null;
  $nome = null;
  $login = null;
  $senhaAntiga = null;

  session_start();
  if ($_SESSION["log"] != 'ativo') {
    session_destroy();
    header("location:../index.php");
  }

  if(isset($_GET['alterar'])){
    //1-realizar a consulta
    $id = $_GET['alterar'];
    $alterarUsuario = $usuario->selecionarUsuario($id);
    foreach ($alterarUsuario as $linha){
      $nome = $linha['nome'];
      $login = $linha['usuario'];
      $senhaAntiga = $linha['senha'];
    }
  }

  if(isset($_POST['alterar'])){
    $id = $_GET['alterar'];
    $nome = $_POST['nome'];
    $login = $_POST['usuario'];
    $senha = sha1($_POST['senha']);
    $senha2 = sha1($_POST['senha2']);

    $imagem = $_FILES['imagem'];

    $senhasCorretas = $senha == $senhaAntiga;
    $usuarioValido = $usuario->conferirAlteracao($id, $login);

    if($usuarioValido && $senhasCorretas){
      $usuario->alterar($id, $nome, $login, $senha2, $imagem);
      header("location:pagina_usuario.php");
    }
  }

   if(isset($_GET['excluir'])){
    $id = $_GET['excluir'];

    $usuario->excluir($id);

    $_SESSION["log"] = 'excluido';
    session_destroy();
    header("location:../index.php");
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
     <!-- navbar -->
     <div class="nav">
       <ul>
         <li><a class="" href="./pagina_usuario.php">Home</a></li>
         <div style="float:right">
           <li><a class="active" href="">Alterar</a></li>
           <li><a href="javascript:sair()">Sair</a></li>
         </div>
       </ul>
     </div>
     <!-- fim da navbar -->

     <!-- Formulário de alteracao -->
     <form action="" method="POST" enctype="multipart/form-data">
       <div class="container">
         <br>
         <label for="imagem">Selecione seu avatar (png ou jpg)</label>
         <br>
         <img id="output" width="100" src="../img/user.png" alt="Avatar" class="avatar">
         <br><br>
         <input type="file" name="imagem" id="imagem" file-accept="jpg png" onchange="loadFile(event)">
         <br>
       </div>

       <div class="container">
         <label>Nome</label><br>
         <input id="alteracao" type="TEXT" placeholder="Insira um novo nome" name="nome" required value="<?php echo $nome; ?>">
         <br>
         <label>Login</label><br>
         <input id="alteracao" type="TEXT" placeholder="Insira um novo usuario" name="usuario" required value="<?php echo $login; ?>">
         <br>
         <label>Senha Antiga</label><br>
         <input id="alteracao" type="PASSWORD" placeholder="Insira sua senha antiga" name="senha" required>
         <br>
         <label>Nova senha</label><br>
         <input id="alteracao" type="PASSWORD" placeholder="Insira sua nova senha" name="senha2" required>
         <br>
         <input type="SUBMIT" value="Alterar" class="button" id="btnEnviar" name="alterar"/>
         <?php
           if(!$usuarioValido){
             echo "<p style='color:red;'>Usuario existente!</p>";
           } else if(!$senhasCorretas){
             echo "<p style='color:red;'>Senha incorreta!</p>";
           }
         ?>
         <div class="container" style="background-color:#f1f1f1; text-align: right">
           <p>Clique abaixo se deseja excluir o usuario (caminho sem volta)</p>
           <button style="color:white;" type="button" class="btnCancelar"
           onclick="excluir(<?php echo $id ?>)">Excluir</button>
         </div>
       </div>
     </form>
   </body>
</html>
