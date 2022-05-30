<?php

require_once "model/CRUD.php";

class ThreadDB extends CRUD {
    public static $table_name = "thread";
    public static $table_columns = [
        "id" => PDO::PARAM_INT,
        "title" => PDO::PARAM_STR,
        "description" => PDO::PARAM_STR,
        "category" => PDO::PARAM_INT,
        "created_timestamp" => PDO::PARAM_INT,
        "original_poster" => PDO::PARAM_INT,
        "original_post" => PDO::PARAM_INT,
        "locked" => PDO::PARAM_INT,
    ];

    public static function postCount($id) {
        $db = DBInit::getInstance();
        $query = "SELECT COUNT(*) FROM post WHERE thread = :id";
        $statement = $db->prepare($query);
        $statement->bindValue(":id", $id);
        $statement->execute();
        return $statement->fetchColumn();
    }

    public static function lastPost($id) {
        $db = DBInit::getInstance();
        $query = "SELECT * FROM post, user WHERE user.id = post.user AND thread = :id ORDER BY created_timestamp DESC LIMIT 1";
        $statement = $db->prepare($query);
        $statement->bindValue(":id", $id);
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}