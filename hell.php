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


1) "added folder/file on .ignore but not removed from git how we can remove from git"
 - "git rm -r --cached vendor"

2) "git multiple commits range"
 - "git revert develop~4..develop~2"

3) "don't create a revert commit"
    "git revert -n HEAD"
?>