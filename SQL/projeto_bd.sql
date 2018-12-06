CREATE DATABASE projetobd;

USE projetobd;

CREATE TABLE usuario (
  ID INT(11) NOT NULL AUTO_INCREMENT,
  nome VARCHAR(250) DEFAULT NULL,
  usuario VARCHAR(250) NOT NULL,
  foto VARCHAR(250) DEFAULT NULL,
  senha VARCHAR(250) NOT NULL,
  PRIMARY KEY (ID),
  UNIQUE KEY usuario (usuario)
);

CREATE TABLE imagem (
  ID INT(11) NOT NULL AUTO_INCREMENT,
  nome VARCHAR(250) NOT NULL,
  nome_arquivo VARCHAR(250) NOT NULL,
  descricao VARCHAR(250) NOT NULL,
  ID_usuario INT,
  PRIMARY KEY (ID),
  FOREIGN KEY (ID_usuario) REFERENCES usuario(ID)
);

-- drop database projeto_bd;
