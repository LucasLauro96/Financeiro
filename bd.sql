CREATE DATABASE financeiro	;

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
    Descricão TEXT,
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

CREATE DEFINER=`root`@`localhost` PROCEDURE `STP_D_Conta`(VarCodConta INT)
BEGIN
	DELETE FROM tb_conta WHERE CodConta = VarCodConta;
END

CREATE DEFINER=`root`@`localhost` PROCEDURE `STP_I_Conta`(VarBanco VARCHAR(35), VarSaldo DOUBLE)
BEGIN
	INSERT INTO tb_conta(Banco, Saldo)
    VALUES(VarBanco, VarSaldo);
    
    SELECT LAST_INSERT_ID() AS CodConta FROM tb_conta LIMIT 1;
END

CREATE DEFINER=`root`@`localhost` PROCEDURE `STP_S_Conta`(VarCodConta INT)
BEGIN
	SELECT CodConta, Banco, Saldo FROM tb_conta WHERE CodConta = VarCodConta;
END

CREATE DEFINER=`root`@`localhost` PROCEDURE `STP_U_Conta`(VarCodConta INT, VarBanco VARCHAR(100), VarSaldo DOUBLE)
BEGIN
	UPDATE tb_conta SET
		Banco = VarBanco,
        Saldo = VarSaldo
	WHERE
		CodConta = VarCodConta;
        
	SELECT VarCodConta AS CodConta;
END