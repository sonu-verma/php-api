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

    if($_SERVER['REQUEST_METHOD'] === "POST"){
        $data = json_decode(file_get_contents("php://input"));
        if(!empty($data->email) && !empty($data->password)){
            $user_obj->email = $data->email;
            $user_obj->password = $data->password;
            $user_data = $user_obj->check_login();
            if(!empty($user_data)){

                $name = $user_data['name'];
                $email = $user_data['email'];
                $password = $user_data['password'];

                if( password_verify($user_obj->password,$password) ){
                    $iss = "localhost";
                    $iat = time();
                    $nbf = $iat + 10;
                    $exp = $iat + 30;
                    $aud = "myusers";
                    $user_arr_data = array(
                        'id' => $user_data['id'],
                        'name' => $name,
                        'email' => $email,
                    );
                    $payload_info = array(
                        "iss" => $iss,
                        "iat" => $iat,
                        "nbf" => $nbf,
                        "exp" => $exp,
                        "aud" => $aud,
                        "data" => $user_arr_data
                    );

                    $secret_key = "owt125";
                    $jwt = JWT::encode($payload_info, $secret_key,"HS512");
                    http_response_code(200);
                    echo json_encode(
                        array(
                            "status" => 1,
                            "jwt" => $jwt,
                            "message"=> "User login succcessfully."
                        )
                    );
                }else{
                    http_response_code(404);
                    echo json_encode(
                        array(
                            "status" => 0,
                            "message"=>"Please check password."
                        )
                    );
                }

            }else{
                http_response_code(404);
                echo json_encode(
                    array(
                        "status" => 0,
                        "message"=>"User not exists. Please try again."
                    )
                );
            }
        }else{
            http_response_code(400);
            echo json_encode(
                array(
                    "status" => 0,
                    "message"=>"All data needed"
                )
            );
        }
    }

