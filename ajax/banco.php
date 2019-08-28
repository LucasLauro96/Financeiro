<?php
require_once '../assets/include/config.php';

$autenticacao = new autenticacao();
$autenticacao->verifica_sessao(basename($_SERVER['PHP_SELF']));

$conexao = new conexao();
$con = $conexao->conecta();

if(!isset($_GET['option']) || empty($_GET['option']))
    exit('GET option required');
    
if(!isset($_POST) || empty($_POST))
    exit('POST required');

    if($_GET['option'] == 'insert'){
        if(!isset($_POST) || empty($_POST))
            exit('POST required');
    
        $query = $con->prepare('CALL STP_I_Banco(:Banco, :Saldo)');
        $query->bindValue(':Banco', $_POST['Banco']);
        $query->bindValue(':Saldo', $_POST['Saldo']);
        $query->execute();
        $res = $query->fetch(PDO::FETCH_OBJ);
        
        $response['CodConta'] = $res->CodConta;

    
    }
