<?php

    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");
    
    $Recebido = file_get_contents("php://input");
    $dados = json_decode($Recebido);

    $key = $dados->{'key'};
    $id = $dados->{'id'};

    $smtp = $PDO->prepare("SELECT A.auth_key,U.user_id FROM tb_auth A INNER JOIN tb_user U on U.user_id = A.auth_user_id WHERE A.auth_key = :key ");
    $smtp->execute(array(
        "key"=>$key
    ));

    if($smtp->rowCount() >0){
        
            $json = array(
                "status"=> true,
                "qnt"=> 0
            );
            echo json_encode($json);
            


        }else{
            $json = array(
                "status"=> true,
                "qnt"=> 0
            );
            echo json_encode($json);
        }

    }else{
        $json = array("status"=>false);

        echo json_encode($json);
    }

    