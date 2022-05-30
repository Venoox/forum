<?php

require_once "model/CRUD.php";

class CategoryDB extends CRUD {
    public static $table_name = "category";
    public static $table_columns = [
        "id" => PDO::PARAM_INT,
        "title" => PDO::PARAM_STR,
        "description" => PDO::PARAM_STR,
        "parent_category" => PDO::PARAM_INT,
    ];

    public static function categoryThreadCount($id) {
        $db = DBInit::getInstance();
        $sql = "SELECT COUNT(*) FROM thread WHERE category = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        if ($count != null) {
            return $count;
        } else {
            return 0;
        }
    }

    public static function categoryPostCount($id) {
        $db = DBInit::getInstance();
        $sql = "SELECT COUNT(*) FROM post WHERE post.thread IN (SELECT thread.id from thread WHERE thread.category = :id);";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        $count = $stmt->fetchColumn();
        if ($count != null) {
            return $count;
        } else {
            return 0;
        }
    }

    public static function categoryLastPost($id) {
        $db = DBInit::getInstance();
        $sql = "SELECT * FROM post, user, thread WHERE post.user = user.id AND post.thread = thread.id AND post.thread IN (SELECT thread.id from thread WHERE thread.category = :id) ORDER BY post.created_timestamp DESC LIMIT 1;";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}