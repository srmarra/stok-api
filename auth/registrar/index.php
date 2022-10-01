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
            $senha =  password_hash($dados->{'senha'}, PASSWORD_DEFAULT);
            $stmt = $PDO->prepare("INSERT INTO `tb_user` (`user_id`, `user_name`, `user_email`, `user_password`) VALUES (NULL, :name , :email , '$senha' )");
            





             $stmt->execute(array(
                'name'=>$dados->{'nome'},
                'email'=>$dados->{'email'},
            ));

            //Gerador de Keys
            regenerar:
            $key = uniqid("key_",true);

            $stmt = $PDO->prepare('SELECT * from tb_auth where auth_key = :key');
            $stmt->execute(array(
                "key" => $key
            ));

            if($stmt->rowCount() > 0){
                goto regenerar;
            }else{
                $stmt = $PDO->prepare('SELECT * from tb_user where user_email = :email');
                $stmt->execute(array(
                    "email" => $dados->{'email'}
                ));
                $user = $stmt->fetch();


                $stmt = $PDO->prepare('SELECT * from tb_auth where auth_user_id= :id');
                $stmt->execute(array(
                    "id" => $user['user_id']
                ));
            }
            // Gerador de Keys



                $retorno = array(
                    "status" => true,
                    "key" => $key
                );
           
            echo json_encode($retorno);

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