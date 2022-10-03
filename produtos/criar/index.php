<?php 
    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");

    require_once("../../util/pdo_connect.php");
    $key = "";
    $smtp = $PDO->prepare("SELECT A.auth_key,U.user_id FROM tb_auth A INNER JOIN tb_user U on U.user_id = A.auth_user_id WHERE A.auth_key = :key ");
    $user = $stmp->execute(array(
        "key"=>$key
    ));

    if($smtp->rowCount() > 100){
        $smtp = $PDO->prepare("INSERT TO tb_prosutos value(null , :titulo , :desc , :preco , :qnt , :user)");

        $smtp->execute(array(
            "id" => "",
            "desc"=> "",        
            "preco"=> "",
            "qnt"=>"",
            "user"=>""
        ));
    }else{
        $Erro = array(
            "status"=>false
        );
        echo json_encode($Erro);
    }

    