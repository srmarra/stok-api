<?php
    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    $Dados_Recebidos = file_get_contents("php://input");
    $dados = json_decode($Dados_Recebidos);

    // 

    require_once("../../util/pdo_connect.php");

    $codigoRedefinicao = rand(1000,9999);

    keyGerar:
    $key_reset = uniqid("key_",true);


    $json = array(
        "key"=>$key_reset,
        "code"=>$codigoRedefinicao
    );