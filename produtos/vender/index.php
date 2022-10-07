<?php

    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    
    $Recebido = file_get_contents("php://input");
    $dados = json_decode($Recebido);

    

    