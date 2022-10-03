<?php 
    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");

    require_once("../../util/pdo_connect.php");
    $Dados_Recebidos = file_get_contents("php://input");
    $dados = json_decode($Dados_Recebidos);
    $key = $dados->{'key'};
    
    $json = array(
        "status"=>false,
        "key" =>$key
    );
    echo json_encode($json);


    
    