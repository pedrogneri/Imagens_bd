<?php
class Conexao {
  private $host = "127.0.0.1";
  private $usuario = "root";
  private $senha = "12345678";
  private $db = "projetobd";

  private static $_instance;

  public static function getInstance (){
    if (!self::$_instance) {
      self ::$_instance = new self();
    }
    return self::$_instance;
  }

  private function __construct() {
    $this->_connection = new mysqli($this->host, $this->usuario, $this->senha, $this->db);

    if (mysqli_connect_error()) {
      trigger_error("ERRO MySQL: " . mysql_connect_error(), E_USER_ERROR);
    }
  }

  private function __clone() {}

  public function getConnection() {
    return $this->_connection;
  }
}
?>
