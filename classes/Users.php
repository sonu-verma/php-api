<?php

Class Users{
    public $name;
    public $email;
    public $password;
    public $user_id;
    public $project_name;
    public $description;
    public $status;

    private $conn;
    private $user_tbl;
    private $project_tbl;

    public function __construct($db)
    {
        $this->conn = $db;
        $this->user_tbl = "users";
        $this->project_tbl = "projects";
    }

    public function create_user(){
        $user_query = "INSERT INTO " .$this->user_tbl. " SET name = ?, email = ?, password = ? ";
        $user_obj = $this->conn->prepare($user_query);
        $user_obj->bind_param('sss',$this->name,$this->email,$this->password);
        if($user_obj->execute()){
            return true;
        }
        return false;
    }

    public function check_email(){
        $check_user_email = "SELECT * FROM ".$this->user_tbl." WHERE email = ?";
        $check_user_email_obj = $this->conn->prepare($check_user_email);
        $check_user_email_obj->bind_param('s', $this->email);
        if($check_user_email_obj->execute()){
            $result=  $check_user_email_obj->get_result();
            return $result->fetch_assoc();
        }
        return  array();
    }

    public function check_login(){

        $check_user_email = "SELECT * FROM ".$this->user_tbl." WHERE email = ?";
        $check_user_email_obj = $this->conn->prepare($check_user_email);
        $check_user_email_obj->bind_param('s', $this->email);
        if($check_user_email_obj->execute()){
            $result=  $check_user_email_obj->get_result();
            return $result->fetch_assoc();
        }
        return  array();

    }

    public function create_project(){
        $create_project_query = "INSERT INTO ".$this->project_tbl." SET user_id = ? , name = ? , description = ? , status = ?";
        $create_project_query_obj = $this->conn->prepare($create_project_query);
        $project_name = htmlspecialchars(strip_tags($this->project_name));
        $desc = htmlspecialchars(strip_tags($this->description));
        $status = htmlspecialchars(strip_tags($this->status));
        $create_project_query_obj->bind_param('issi',$this->user_id,$project_name,$desc,$status);
        if($create_project_query_obj->execute()){
            return true;
        }
        return false;
    }

    public function app_project_list(){
        $get_project_query =  "SELECT * FROM ".$this->project_tbl." ORDER BY id DESC";
        $get_project_query_obj = $this->conn->prepare($get_project_query);
        $get_project_query_obj->execute();
        return $get_project_query_obj->get_result();
    }
}