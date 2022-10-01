<?php



    header('Content-Type: application/json');
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Headers: *");


    require_once('../../util/pdo_connect.php');
    $status = false;
    $dados = json_decode(file_get_contents("php://input"));
    if(isset($dados->{"nome"})){
        $email = $dados->{'email'};
        $stmt = $PDO->prepare('SELECT * from tb_user where user_email = :email');
        $stmt->execute(array('email' => $email));

        if($stmt->rowCount() == 0){
            

                $retorno = array(
                    "status" => true,
                    "key" => 2
                );
           

        }else{
            $retorno = array(
                "status" => false,
                "erro" => 2
            );
    
            echo json_encode($retorno);
        }
       
            
            




    }else{
        $retorno = array(
            "status" => false,
            "erro" => 2
        );

        echo json_encode($retorno);
    }



?>