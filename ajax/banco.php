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

    if($_GET['option'] == 'select'){
        if(!isset($_POST) || empty($_POST))
            exit('POST required');
    
        $query = $con->prepare('CALL STP_S_Conta(:CodConta)');
        $query->bindValue(':CodConta', $_POST['CodConta']);
        $query->execute();
        $res = $query->fetch(PDO::FETCH_OBJ);
        
        echo json_encode($res);

    }    

    if($_GET['option'] == 'insert'){
        if(!isset($_POST) || empty($_POST))
            exit('POST required');

        $Saldo = str_replace('.', '', $_POST['Saldo']);
        $Saldo = str_replace(',', '.', $Saldo);
    
        $query = $con->prepare('CALL STP_I_Conta(:Banco, :Saldo)');
        $query->bindValue(':Banco', $_POST['Banco']);
        $query->bindValue(':Saldo', $Saldo);
        $query->execute();
        $res = $query->fetch(PDO::FETCH_OBJ);
        
        echo json_encode($res);

    }

    if($_GET['option'] == 'update'){
        if(!isset($_POST) || empty($_POST))
            exit('POST required');

        $Saldo = str_replace('.', '', $_POST['Saldo']);
        $Saldo = str_replace(',', '.', $Saldo);
    
        $query = $con->prepare('CALL STP_U_Conta(:CodConta, :Banco, :Saldo)');
        $query->bindValue(':CodConta', $_POST['CodConta']);
        $query->bindValue(':Banco', $_POST['Banco']);
        $query->bindValue(':Saldo', $Saldo);
        $query->execute();
        $res = $query->fetch(PDO::FETCH_OBJ);
        
        echo json_encode($res);
        
    }

    if($_GET['option'] == 'delete'){
        if(!isset($_POST) || empty($_POST))
            exit('POST required');
    
        $query = $con->prepare('CALL STP_D_Conta(:CodConta)');
        $query->bindValue(':CodConta', $_POST['CodConta']);
        $query->execute();

    } 
