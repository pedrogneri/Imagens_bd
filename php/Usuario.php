<?php
class Usuario {
  private $conexao;

  function __construct() {
    //conexao com o banco de dados
    $this->conexao = Conexao::getInstance();
  }

  public function copiarImg($arquivo, $id){
    //configuracoes da img
    $tmpName = $arquivo['tmp_name'];
    $nome = $arquivo['name'];
    $extensao = pathinfo($nome, PATHINFO_EXTENSION);
    $novoNome = sha1($id . $nome) . '.' . $extensao;

    //copia a image para o servidor
    $dir = '../img/';
    move_uploaded_file($tmpName, $dir . $novoNome);

    //salva o novo nome no bd
    $this->conexao->getConnection()->query(
            "UPDATE usuario SET foto='$novoNome' WHERE ID=$id")
            or die ($this->conexao->getConnection()->error);
  }

  //efetua login no sistema
  public function logar($login, $senha) {
    $logado = false;

    //conexão com o bd
    $conexao = Conexao::getInstance();

    //executa o comando SQL
    $resultado = $conexao->getConnection()->query("SELECT * FROM usuario WHERE usuario = '$login' and senha = '$senha'")
            or die($conexao->getConnection()->error);

    //registrar sessão
    if (mysqli_num_rows($resultado) == 1) {
      $dados = mysqli_fetch_assoc($resultado);

      session_start();
      $_SESSION["ID"] = $dados["ID"];
      $_SESSION["nome"] = $dados["nome"];
      $_SESSION["foto"] = $dados["foto"];
      $_SESSION["log"] = "ativo";

      $logado = true;
    }
    return $logado;
  }

  //Salva o usuario no banco de dados
  public function salvar($nome, $usuario, $senha, $arquivo){
    //1. Abrir a conexão
    $this->conexao->getConnection();

    //2. Execute a Query
    $this->conexao->getConnection()->query("INSERT INTO usuario (nome, usuario, senha) VALUES('$nome', '$usuario', '$senha')")
            or die($this->conexao->getConnection()->error);

    //recupera o ultimo id inserido no bd
    $id = $this->conexao->getConnection()->insert_id;

    //chama a funcao responsavel por copiar a img
    $this->copiarImg($arquivo, $id);
  }

  public function conferirUsuario($usuario){
    $usuarioValido = false;
    //conexão com o bd
    $conexao = Conexao::getInstance();

    //executa o comando SQL
    $resultado = $conexao->getConnection()->query("SELECT usuario FROM usuario WHERE usuario = '$usuario'")
            or die($conexao->getConnection()->error);

    if (mysqli_num_rows($resultado) != 1) {
      $usuarioValido = true;
    }
    return $usuarioValido;
  }

  public function conferirAlteracao($idAtual, $usuario){
    $usuarioValido = false;
    //conexão com o bd
    $conexao = Conexao::getInstance();

    //executa o comando SQL
    $resultado = $conexao->getConnection()->query("SELECT ID, usuario FROM usuario WHERE usuario = '$usuario'")
            or die($conexao->getConnection()->error);

    if (mysqli_num_rows($resultado) != 1) {
      $usuarioValido = true;
    } else {
      foreach ($resultado as $linha) {
        $id = $linha['ID'];
      }
      if($id == $idAtual){
        $usuarioValido = true;
      }
    }
    return $usuarioValido;
  }

  function nomeImg(){
    $id = $_GET['alterar'];
    $alterarImg = $imagem->selecionarImg($id);
    foreach ($alterarImg as $linha){
      $nome = $linha['nome'];
      $descricao = $linha['descricao'];
    }
  }

  //retornar TODOS os usuários cadastrados
  public function selecionarTodos(){
    $resultado = $this->conexao->getConnection()->query("SELECT * FROM usuario") or die ($this->conexao->getConnection()->error);
    return $resultado;
  }

  //retorna um usúario
  public function selecionarUsuario($id){
    $resultado = $this->conexao->getConnection()->query("SELECT * FROM usuario WHERE ID=".$id) or die ($this->conexao->getConnesction()->error);
    return $resultado;
  }

  public function excluir($id){
    $this->conexao->getConnection()->query("DELETE FROM imagem WHERE ID_usuario=$id") or die ($this->conexao->getConnection()->error);
    $this->conexao->getConnection()->query("DELETE FROM usuario WHERE ID=$id") or die ($this->conexao->getConnection()->error);
  }

  public function alterar($id, $nome, $usuario, $senha, $arquivo){
    $this->conexao->getConnection()->query(
      "UPDATE usuario SET nome='".$nome."', usuario='".$usuario."', senha='".$senha."' WHERE ID=".$id)
            or die($this->conexao->getConnection()->error);

    $this->copiarImg($arquivo, $id);
  }
}
?>
