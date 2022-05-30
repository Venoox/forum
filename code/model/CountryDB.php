<?php

require_once "model/CRUD.php";

class CountryDB extends CRUD {
    public static $table_name = "country";
    public static $table_columns = [
        "id" => PDO::PARAM_INT,
        "name" => PDO::PARAM_STR,
    ];
}