<?php

ALTER TABLE users MODIFY password VARCHAR(100) ;


CREATE TABLE users (
    id int NOT NULL AUTO_INCREMENT,
    name varchar(50) NOT NULL,
    email varchar(50),
    password varchar(50),
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);


CREATE TABLE projects (
    id int NOT NULL AUTO_INCREMENT,
    user_id int(11) NOT NULL,
    name varchar(50) NOT NULL,
    description text NULL,
    status int,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
);
?>