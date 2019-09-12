<?php

require_once '../../assets/include/config.php';

$autenticacao = new autenticacao();
$autenticacao->verifica_sessao(basename($_SERVER['PHP_SELF']));

$conexao = new conexao();
$con = $conexao->conecta();

if(!isset($_GET['option']) || empty($_GET['option']))
    exit('GET option required');
    
if(!isset($_POST) || empty($_POST))
    exit('POST required');

if($_GET['option'] == 'select'){
    $query = $con->prepare('CALL STP_S_Associado(:IDAssociado)');
    $query->bindValue(':IDAssociado', $_POST['IDAssociado']);
    $query->execute();
    $res = $query->fetch(PDO::FETCH_OBJ);
    echo json_encode($res);
}

if($_GET['option'] == 'insert'){
    $query = $con->prepare('CALL STP_I_Associado(:IDGrupo, :CPF_CNPJ, :Nome, :Email, :Telefone, :Celular, :CEP, :Endereco, :Numero, :Bairro, :Cidade, :UF, :Complemento, :Ativo, :Vencimento)');
	$query->bindValue(':IDGrupo', $_POST['IDGrupo']);
	$query->bindValue(':CPF_CNPJ', $_POST['CPF_CNPJ']);
	$query->bindValue(':Nome', $_POST['Nome']);
	$query->bindValue(':Email', $_POST['Email']);
	$query->bindValue(':Telefone', !empty($_POST['Telefone']) ? $_POST['Telefone'] : null);
	$query->bindValue(':Celular', !empty($_POST['Celular']) ? $_POST['Celular'] : null);
	$query->bindValue(':CEP', $_POST['CEP']);
	$query->bindValue(':Endereco', $_POST['Endereco']);
	$query->bindValue(':Numero', $_POST['Numero']);
	$query->bindValue(':Bairro', $_POST['Bairro']);
	$query->bindValue(':Cidade', $_POST['Cidade']);
	$query->bindValue(':UF', $_POST['UF']);
	$query->bindValue(':Complemento', !empty($_POST['Complemento']) ? $_POST['Complemento'] : null);
	$query->bindValue(':Ativo', isset($_POST['Ativo']) ? 1 : 0);
	$query->bindValue(':Vencimento', $_POST['Vencimento']);
	$query->execute();
	$res = $query->fetch(PDO::FETCH_OBJ);
	echo json_encode($res);
}

if($_GET['option'] == 'update'){
    $query = $con->prepare('CALL STP_U_Associado(:IDAssociado, :IDGrupo, :CPF_CNPJ, :Nome, :Email, :Telefone, :Celular, :CEP, :Endereco, :Numero, :Bairro, :Cidade, :UF, :Complemento, :Ativo, :Vencimento)');
	$query->bindValue(':IDAssociado', $_POST['IDAssociado']);
	$query->bindValue(':IDGrupo', $_POST['IDGrupo']);
	$query->bindValue(':CPF_CNPJ', $_POST['CPF_CNPJ']);
	$query->bindValue(':Nome', $_POST['Nome']);
	$query->bindValue(':Email', $_POST['Email']);
	$query->bindValue(':Telefone', !empty($_POST['Telefone']) ? $_POST['Telefone'] : null);
	$query->bindValue(':Celular', !empty($_POST['Celular']) ? $_POST['Celular'] : null);
	$query->bindValue(':CEP', $_POST['CEP']);
	$query->bindValue(':Endereco', $_POST['Endereco']);
	$query->bindValue(':Numero', $_POST['Numero']);
	$query->bindValue(':Bairro', $_POST['Bairro']);
	$query->bindValue(':Cidade', $_POST['Cidade']);
	$query->bindValue(':UF', $_POST['UF']);
	$query->bindValue(':Complemento', !empty($_POST['Complemento']) ? $_POST['Complemento'] : null);
	$query->bindValue(':Ativo', isset($_POST['Ativo']) ? 1 : 0);
	$query->bindValue(':Vencimento', $_POST['Vencimento']);
	$query->execute();
	$res = $query->fetch(PDO::FETCH_OBJ);
	echo json_encode($res);
}

if($_GET['option'] == 'delete'){
	$query = $con->prepare('CALL STP_D_Associado(:IDAssociado)');
	$query->bindValue(':IDAssociado', $_POST['IDAssociado']);
    $query->execute();
    $res = $query->fetch(PDO::FETCH_OBJ);
	echo json_encode($res);
}