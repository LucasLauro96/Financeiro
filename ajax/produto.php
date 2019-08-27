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

	//ENVIA A IMAGEM
	if(!empty($_FILES['Imagem']['name'])){
		$extensao = strtolower(substr($_FILES['Imagem']['name'], -5));
		$novo_nome = md5(date('Y-m-d H:i:s')).$extensao;
		$destino = '../../assets/img/produto/'.$novo_nome;

		//MOVE PARA PASTA
		move_uploaded_file($_FILES['Imagem']['tmp_name'], $destino);

		//CADASTRA O REGISTRO NO BANCO
		$query = $con->prepare('CALL STP_I_Produto(:Titulo, :Imagem, :Ativo)');
		$query->bindValue(':Titulo', $_POST['Titulo']);
		$query->bindValue(':Imagem', $novo_nome);
		$query->bindValue(':Ativo', $_POST['Ativo']);
		$query->execute();
		$res = $query->fetch(PDO::FETCH_OBJ);

		$response['CodProduto'] = $res->CodProduto;

		echo json_encode($response);
	}

}

if($_GET['option'] == 'update'){
	if(!isset($_POST) || empty($_POST))
		exit('POST required');

	//ENVIA A IMAGEM
	if(!empty($_FILES['Imagens']['name'])){
		$extensao = strtolower(substr($_FILES['Imagens']['name'], -5));
		$novo_nome = md5(date('Y-m-d H:i:s')).$extensao;
		$destino = '../../assets/img/produto/'.$novo_nome;

		$query = $con->prepare('UPDATE tb_produto SET Imagem=:Imagem WHERE CodProduto = :CodProduto');
		$query->bindValue(':CodProduto', $_POST['CodProduto']);
		$query->bindValue(':Imagem', $novo_nome);
		$query->execute();

		//MOVE PARA PASTA
		move_uploaded_file($_FILES['Imagens']['tmp_name'], $destino);
		
	}
		$query = $con->prepare('CALL STP_U_Produto(:CodProduto, :Titulo, :Ativo)');
		$query->bindValue(':CodProduto', $_POST['CodProduto']);
		$query->bindValue(':Titulo', $_POST['Titulo']);
		$query->bindValue(':Ativo', $_POST['Ativo']);
		$query->execute();
		$res = $query->fetch(PDO::FETCH_OBJ);

		$response['CodProduto'] = $res->CodProduto;

		echo json_encode($response);

}

if($_GET['option'] == 'delete'){
	if(!isset($_POST) || empty($_POST))
		exit('POST required');

	//EXLUI A IMAGEM DA PASTA
	$query = $con->prepare('SELECT Imagem FROM tb_produto WHERE CodProduto = :CodProduto');
	$query->bindValue(':CodProduto', $_POST['CodProduto']);
	$query->execute();
	$res = $query->fetch(PDO::FETCH_OBJ);
	unlink('../../assets/img/produto/'.$res->Imagem);

	//EXCLUI DO BANCO
	$query = $con->prepare('DELETE FROM tb_produto WHERE CodProduto = :CodProduto');
	$query->bindValue(':CodProduto', $_POST['CodProduto']);
	$query->execute();
}


?>