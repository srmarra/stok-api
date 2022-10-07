<?php
    require_once("../../util/pdo_connect.php");
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
    
        $smtp = $PDO->prepare("SELECT * from tb_produtos where prod_id = :id");

        $smtp->execute(array(
            "id"=>$id
        ));

        $prod = $smtp->fetch();
        $qnt = $prod['prod_qnt'] - 1;
        if($qnt >= 0){
            $smtp = $PDO->prepare("UPDATE tb_produtos SET prod_qnt = :qnt where  prod_id = :id");
            $smtp->execute(array(
                "qnt"=> $qnt,
                "id"=> $id
            ));

            $json = array(
                "status"=> true,
                "qnt"=> $qnt+1
            );
            echo json_encode($json);
            


        }else{
            $json = array(
                "status"=> true,
                "qnt"=> $qnt
            );
        echo json_encode($json);
        }

    }else{
        $json = array("status"=>false);

        echo json_encode($json);
    }

    