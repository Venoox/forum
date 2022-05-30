<?php

require_once "model/CRUD.php";

class PostDB extends CRUD {
    public static $table_name = "post";
    public static $table_columns = [
        "id" => PDO::PARAM_INT,
        "thread" => PDO::PARAM_INT,
        "user" => PDO::PARAM_INT,
        "content" => PDO::PARAM_STR,
        "created_timestamp" => PDO::PARAM_INT,
        "modified_timestamp" => PDO::PARAM_INT,
    ];
}