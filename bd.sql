CREATE DATABASE financeiro;

USE financeiro;

CREATE TABLE tb_usuario_adm(
	CodUsuario INT PRIMARY KEY AUTO_INCREMENT,
    Nome VARCHAR(255) NOT NULL,
    Usuario VARCHAR(255) NOT NULL,
    Senha VARCHAR(255) NOT NULL
);

INSERT INTO tb_usuario_adm(Nome, Usuario, Senha)
VALUE ('Lucas Lauro', 'lucaskns', '20101996');

CREATE TABLE tb_conta(
	CodConta INT PRIMARY KEY AUTO_INCREMENT,
    Banco VARCHAR(35) NOT NULL,
    Saldo DOUBLE NOT NULL
);

SELECT * FROM tb_conta;

CREATE TABLE tb_despesa(
	CodDespesa INT PRIMARY KEY AUTO_INCREMENT,
    DataDespesa DATE NOT NULL,
    Descricao TEXT,
    Valor DOUBLE
);

CREATE TABLE tb_transferencia(
	CodTransferencia INT PRIMARY KEY AUTO_INCREMENT,
    CodContaOrigem INT,
    CodContaDestino INT,
    ContaExterna VARCHAR(255),
    Valor DOUBLE,
    FOREIGN KEY (CodContaOrigem) REFERENCES tb_conta(CodConta),
    FOREIGN KEY (CodContaDestino) REFERENCES tb_conta(CodConta)
);