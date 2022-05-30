<?php

require_once "model/CRUD.php";

class RoleDB extends CRUD {
    public static $table_name = "role";
    public static $table_columns = [
        "id" => PDO::PARAM_INT,
        "role" => PDO::PARAM_STR,
    ];
}