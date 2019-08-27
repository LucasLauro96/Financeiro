<?php

if (!isset($_POST['usuario'], $_POST['senha']))
	exit;

require_once '../include/config.php';

$autenticacao = new autenticacao();
$retorno = $autenticacao->cria_sessao($_POST['usuario'], $_POST['senha']);

echo $retorno;

?>