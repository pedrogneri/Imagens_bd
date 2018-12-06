<?php
class Imagem {
  private $conexao;

  function __construct() {
    //conexao com o banco de dados
    $this->conexao = Conexao::getInstance();
  }

  public function salvarImg($nome, $arquivo, $descricao, $idUsuario){
    //configuracoes da img
    $tmpName = $arquivo['tmp_name'];
    $nomeArquivo = $arquivo['name'];
    $extensao = pathinfo($nomeArquivo, PATHINFO_EXTENSION);
    $novoNome = sha1($idUsuario . $nomeArquivo) . '.' . $extensao;

    //copia a image para o servidor
    $dir = '../img/';
    move_uploaded_file($tmpName, $dir . $novoNome);

    //salva o novo nome no bd
    $this->conexao->getConnection()->query(
            "INSERT INTO imagem (nome, nome_arquivo, descricao, ID_usuario)
            VALUES ('$nome', '$novoNome',  '$descricao', $idUsuario)")
            or die ($this->conexao->getConnection()->error);
  }

  //retornar TODAS as imagens cadastradas do usuario
  public function selecionarTodasImg($id){
    $resultado = $this->conexao->getConnection()->query("SELECT * FROM imagem WHERE ID_usuario=".$id)
    or die ($this->conexao->getConnection()->error);
    return $resultado;
  }

  //retorna uma img
  public function selecionarImg($id){
    $resultado = $this->conexao->getConnection()->query("SELECT * FROM imagem WHERE ID=".$id)
    or die ($this->conexao->getConnesction()->error);
    return $resultado;
  }

  public function excluirImg($id){
    $this->conexao->getConnection()->query("DELETE FROM imagem WHERE ID=".$id)
    or die ($this->conexao->getConnection()->error);
  }
}
?>
