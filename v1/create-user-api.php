<?php
   // include header
    ini_set('display_errors',1);

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST');
    header('Content-Type: application/json; charset=UTF-8');

    //include files

    include_once("../config/database.php");
    include_once("../classes/Users.php");

    $db = new Database();
    $connection = $db->connect();
    $user_obj = new Users($connection);

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        $data  = json_decode(file_get_contents("php://input"));
        if(!empty($data->name) && !empty($data->email) && !empty($data->password) ){

            $user_obj->name = $data->name;
            $user_obj->email = $data->email;
            $user_obj->password =  password_hash($data->password, PASSWORD_DEFAULT);

            if($user_obj->create_user()){
                http_response_code(200);
                echo json_encode(array('status'=>1,'message'=>"successfully inserted data.",'response_code'=>http_response_code(200)));
            }else{
                http_response_code(500);
                echo json_encode(array('status'=>0,'message'=>"data not saved.",'response_code'=>http_response_code(500)));
            }
        }else{
            http_response_code(500);
            echo json_encode(array('status'=>0,'message'=>"Please enter data"));
        }
    }else{
        http_response_code(503);
        echo json_encode(array('status'=>0,'message'=>"Access Denie"));
    }

 ?>
