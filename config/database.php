<?php
// DB.class.php

class Database   {

    private $db_name = 'api';
    private $db_user = 'user';
    private $db_pass = 'User@123';
    private $db_host = 'localhost';

    // Open a connect to the database.
    // Make sure this is called on every page that needs to use the database.

    public function connect() {

            $connect_db = new mysqli( $this->db_host, $this->db_user, $this->db_pass, $this->db_name );

            if ( mysqli_connect_errno() ) {
                printf("Connection failed: %s\
    ", mysqli_connect_error());
                exit();
            }else{
                return $connect_db;
            }
        }


    }
