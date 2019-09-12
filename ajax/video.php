<?php

require_once '../../assets/include/config.php';

$autenticacao = new autenticacao();
$autenticacao->verifica_sessao(basename($_SERVER['PHP_SELF']));

$conexao = new conexao();
$con = $conexao->conecta();

if(!isset($_GET['option']) || empty($_GET['option']))
	exit('GET option required');

if($_GET['option'] == 'insert'){
	if(!isset($_POST) || empty($_POST))
		exit('POST required');

		//CADASTRA O REGISTRO NO BANCO
		$query = $con->prepare('CALL STP_I_Video(:Titulo, :Video, :Ativo)');
		$query->bindValue(':Titulo', $_POST['Titulo']);
		$query->bindValue(':Video', $_POST['Video']);
		$query->bindValue(':Ativo', $_POST['Ativo']);
		$query->execute();
		$res = $query->fetch(PDO::FETCH_OBJ);

		$response['CodVideo'] = $res->CodVideo;

		echo json_encode($response);
}

if($_GET['option'] == 'update'){
	if(!isset($_POST) || empty($_POST))
		exit('POST required');

		$query = $con->prepare('CALL STP_U_Video(:CodVideo, :Titulo, :Video, :Ativo)');
		$query->bindValue(':CodVideo', $_POST['CodVideo']);
		$query->bindValue(':Titulo', $_POST['Titulo']);
		$query->bindValue(':Video', $_POST['Video']);
		$query->bindValue(':Ativo', $_POST['Ativo']);
		$query->execute();
		$res = $query->fetch(PDO::FETCH_OBJ);

		$response['CodVideo'] = $res->CodVideo;

		echo json_encode($response);

}

if($_GET['option'] == 'delete'){
	if(!isset($_POST) || empty($_POST))
		exit('POST required');

	//EXCLUI DO BANCO
	$query = $con->prepare('DELETE FROM tb_video WHERE CodVideo = :CodVideo');
	$query->bindValue(':CodVideo', $_POST['CodVideo']);
	$query->execute();
}


?>