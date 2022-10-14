<?php

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
$Dados_Recebidos = file_get_contents("php://input");
$dados = json_decode($Dados_Recebidos);


require_once("../../util/pdo_connect.php");//Conexão com banco de dados

$smtp = $PDO->prepare("SELECT * FROM tb_resetPass where reset_key = :key");

$smtp->execute(array(
    "key"=> $dados->{'key'}
));


if($smtp->rowCount() == 1){

    $smtp = $PDO->prepare("SELECT * FROM tb_resetPass where reset_key = :key and reset_code = :code");

    $smtp->execute(array(
        "key"=> $dados->{'key'},
        "code"=> $dados->{'code'}
    ));

    if($smtp->rowCount() == 1){

        $smtp = $PDO->prepare("UPDATE tb_resetPass set reset_status = 1");

        $json=array(
            "status"=>true
        );
    }else{
        $json=array(
            "status"=>false
        );
    }
    

    echo json_encode($json);
}else{
    $json = array(
        "status"=>false
    );
    echo json_encode($json);
}