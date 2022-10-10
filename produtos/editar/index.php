<?php

    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");

    $Dados_Recebidos = file_get_contents("php://input");
    $dados = json_decode($Dados_Recebidos);

    $json = array(
        "status" => true,
        "Titulo"=> $dados->{'titulo'}
    );  

    
    echo json_encode($json);


