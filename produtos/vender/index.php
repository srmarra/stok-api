<?php

    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    
    $json = array("status"=>false);

    echo json_encode($json);