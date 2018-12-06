<?php
  include '../php/Conexao.php';
  include '../php/Usuario.php';
  include '../php/Imagem.php';

  session_start();
  if ($_SESSION["log"] != 'ativo') {
    session_destroy();
    header("location:../index.php");
  }
  if (isset($_GET ['sair'])) {
    session_destroy();
    header ("location:../index.php");
  }

  $imagem = new Imagem();

  $nome = null;
  $descricao = null;
  $idUsuario = null;
  $imagens = $imagem->selecionarTodasImg($_SESSION['ID']);

  if(isset($_POST['enviar'])){
    $nome = $_POST['nome'];
    $descricao = $_POST['descricao'];
    $idUsuario = $_SESSION['ID'];

    $arquivo = $_FILES['imagem'];

    $imagem->salvarImg($nome, $arquivo, $descricao, $idUsuario);

    header("location:pagina_usuario.php");
  }

  if(isset($_GET['excluir'])){
    $id = $_GET['excluir'];

    $imagem->excluirImg($id);

    header("location:pagina_usuario.php");
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
        <li><a class="active" href="#">Home</a></li>
        <div style="float:right">
          <li><a href='javascript:alterar(<?php echo $_SESSION["ID"];?>)'>Alterar</a></li>
          <li><a href="javascript:sair()">Sair</a></li>
        </div>
      </ul>
    </div>
    <!-- fim da navbar -->
    <?php
      $conexao = Conexao::getInstance();
    ?>
    <div class="cabecalho">
      <p>
        <img src="../img/<?php echo $_SESSION["foto"]; ?>" width="150" height="150"><br>
        <b style="font-size: 30px;">Bem vindo, <?php echo $_SESSION["nome"];?>!</b>
      </p>
      <hr>
    </div>

    <div style="padding: 16px">
      <form action="" method="POST" enctype="multipart/form-data">
        <div>
          <label for="imagem">Selecionar a imagem em png ou jpg</label>
          <br>
          <img class="imagem" id="output" width="100" src="../img/noimg.png">
          <br><br>
          <input type="file" name="imagem" id="imagem" file-accept="jpg png" onchange="loadFile(event)">
        </div>

        <br>
        <label>Nome da imagem</lable>
        <br>
        <input id="alteracao" type="TEXT" name="nome" value="<?php echo $nome; ?>" required>
        <br><br>
        <label>Descrição</lable>
        <br>
        <textarea id="alteracao" type="textfield" name="descricao" rows="2" required><?php echo $descricao ?></textarea>
        <br><br>
        <input class="button" id="btnEnviar" type="SUBMIT" name="enviar">
      </form>
      <hr>
      <h2>Imagens cadastradas</h2>
      <?php
        echo "<table>
              <tr>
              <th>Imagem</th>
              <th>Nome</th>
              <th>Descricao</th>
              <th>Excluir</th>
              </tr>
            ";
        foreach($imagens as $linha){
          echo "<tr>
                <td><img class='imagem' src='../img/".$linha['nome_arquivo']."'></td>
                <td>".$linha['nome']."</td>
                <td>".$linha['descricao']."</td>
                <td><a href='javascript:excluirImg(".$linha['ID'].")'>Excluir</a></td>
                </tr>";
        }
        echo "</table>";
      ?>
    </div>
  </body>
</html>
