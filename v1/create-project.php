<?php

    ini_set('display_errors', 1);

    require '../vendor/autoload.php';
    use \Firebase\JWT\JWT;
    // include header

    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Methods: POST');
    header('Content-Type: application/json; charset=UTF-8');

    //include files

    include_once("../config/database.php");
    include_once("../classes/Users.php");

    $db = new Database();
    $connection = $db->connect();
    $user_obj = new Users($connection);

    if ($_SERVER['REQUEST_METHOD'] === "POST") {


        $data = json_decode(file_get_contents("php://input"));

        if(isset($data->pname) && isset($data->desc) && isset($data->status)){
            try{
                $secret_key = "owt125";
                $headers = getallheaders();
                $jwt_token = $headers["x_access-token"];
                $decode_user_data = JWT::decode($jwt_token, $secret_key, array("HS512"));

                $user_obj->user_id = $decode_user_data->data->id;
                $user_obj->project_name = $data->pname;
                $user_obj->description = $data->desc;
                $user_obj->status = $data->status;

                if($user_obj->create_project()){
                    http_response_code(200);
                    echo json_encode(array(
                        "status"=>0,
                        "message"=>"successfully project created."
                    ));
                }else{
                    http_response_code(500);
                    echo json_encode(array(
                        "status"=>0,
                        "message"=>"Project can't be crated."
                    ));
                }
            }catch (Exception $exception){
                http_response_code(404);
                echo json_encode(array(
                    "status"=>0,
                    "message"=>"Invalid token."
                ));
            }
        }else{
            http_response_code(403);
            echo json_encode(array(
                "status"=>0,
                "message"=>"Please enter all field."
            ));
        }
    }

?>