<?php
    ini_set('display_errors',1);

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

    if($_SERVER['REQUEST_METHOD'] === "POST") {
        //$data = json_decode(file_get_contents("php://input"));
        $getAllHeader = getallheaders();
        $jwt = $getAllHeader['x_access-token'];
        if(!empty($jwt)){

            try{
                $secret_key = "owt125";
                $decoded_data = JWT::decode($jwt, $secret_key, array('HS512'));
                $user_id =$decoded_data->data->id;
                http_response_code(200);
                echo json_encode(
                    array(
                        "status" => 1,
                        "message" => "we got jwt token.",
                        "user_data" => $user_id
                    )
                );
            }catch (Exception $e){
                http_response_code(500);
                echo json_encode(
                    array(
                        "status" => 1,
                        "message" => $e->getMessage(),

                    )
                );
            }



        }
    }
?>