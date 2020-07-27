<?php

    require "../vendor/autoload.php";
    use Firebase\JWT\JWT;

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Method: GET");
    header("Content-Type: application/json; charset: UTF-8");

    include_once("../config/database.php");
    include_once("../classes/Users.php");

    $database = new Database();
    $connection = $database->connect();
    $user_obj = new Users($connection);

    if($_SERVER["REQUEST_METHOD"] === "GET"){
         $all_headers = getallheaders();
         $access_token = $all_headers["x_access-token"];
         $projects = $user_obj->app_project_list();
         if($projects->num_rows > 0){
                $projects_arr = array();
                while ($row = $projects->fetch_assoc()){
                    $projects_arr[] = array(
                      "id" =>$row['id'],
                      "project_name"=>$row['name'],
                      "description" => $row['description'],
                      "status" =>$row['status']
                    );
                }
             http_response_code(200);
             echo json_encode(array(
                 "status"=>1,
                 "message"=>"Data found.",
                 "data"=>$projects_arr
             ));

         }else{
             http_response_code(200);
             echo json_encode(array(
                 "status"=>0,
                 "message"=>"No data found"
             ));
         }
    }else{
        http_response_code(400);
        echo json_encode(array(
            "status"=>0,
            "message"=>"Method not allowed"
        ));
    }

?>