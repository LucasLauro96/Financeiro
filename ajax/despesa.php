<?php
require_once '../assets/include/config.php';

$autenticacao = new autenticacao();
$autenticacao->verifica_sessao(basename($_SERVER['PHP_SELF']));

$conexao = new conexao();
$con = $conexao->conecta();

if (!isset($_GET['option']) || empty($_GET['option']))
    exit('GET option required');

if (!isset($_POST) || empty($_POST))
    exit('POST required');

if($_GET['option'] == 'select'){
    $query = $con->prepare("CALL STP_S_Despesa(:CodDespesa)");
    $query->bindValue(':CodDespesa', $_POST['CodDespesa']);
    $query->execute();
    $res = $query->fetch(PDO::FETCH_OBJ);

    echo json_encode($res);
}

if ($_GET['option'] ==  'insert') {

    //TRATANDO O VALOR
    $Valor = str_replace('.', '', $_POST['Valor']);
    $Valor = str_replace(',', '.', $Valor);

    $query = $con->prepare("CALL STP_I_Despesa(:DataDespesa, :Descricao, :Valor)");
    $query->bindValue(':DataDespesa', $_POST['DataDespesa']);
    $query->bindValue(':Descricao', $_POST['Descricao']);
    $query->bindValue(':Valor', $Valor);
    $query->execute();
    
    $res = $query->fetch(PDO::FETCH_OBJ);

    echo json_encode($res);

}
