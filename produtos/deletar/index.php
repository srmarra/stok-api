<?php
    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");



    $json = array(
        "key" => $key,
        "id" => $id
    );

    echo (json_encode($json));