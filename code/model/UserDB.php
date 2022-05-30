<?php

require_once "model/CRUD.php";

class UserDB extends CRUD {
    public static $table_name = "user";
    public static $table_columns = [
        "id" => PDO::PARAM_INT,
        "username" => PDO::PARAM_STR,
        "email" => PDO::PARAM_STR,
        "password" => PDO::PARAM_STR,
        "role" => PDO::PARAM_INT,
        "bio" => PDO::PARAM_STR,
        "profile_picture" => PDO::PARAM_STR,
        "country" => PDO::PARAM_INT,
        "joined_at" => PDO::PARAM_STR,
        "last_active" => PDO::PARAM_STR,
    ];

    public static function login($username, $password) {
        $db = DBInit::getInstance();
        $table_name = static::$table_name;

        $statement = $db->prepare("SELECT * FROM $table_name WHERE (username = :username OR email = :email)");
        $statement->bindParam(":username", $username);
        $statement->bindParam(":email", $username);
        $statement->execute();

        $user = $statement->fetch(PDO::FETCH_ASSOC);
        if (!$user) {
            return null;
        }

        $correct = password_verify($password, $user["password"]);
        if (!$correct) {
            return null;
        }

        return $user;
    }

    public static function register($username, $email, $password) {
        $hash = password_hash($password, PASSWORD_BCRYPT);

        return static::insert([
            "username" => $username,
            "email" => $email,
            "password" => $hash,
            "role" => 3, //user
            "bio" => "",
            "profile_picture" => "assets/profile_pictures/default.png",
            "country" => 1,
        ]);
    }

    public static function getUsersInfo($search_term = "") {
        $db = DBInit::getInstance();

        $statement = $db->prepare("
        SELECT 
            user.id, 
            username, 
            role.role, 
            joined_at, 
            last_active, 
            profile_picture, 
            country.name AS country_name,  
            (SELECT COUNT(*) FROM thread WHERE thread.original_poster = user.id) as thread_count, 
            (SELECT COUNT(*) FROM post WHERE post.thread IN (SELECT id FROM thread WHERE thread.original_poster = user.id)) as post_count 
        FROM user, role, country 
        WHERE user.role = role.id AND user.country = country.id AND user.username LIKE :search_term;");
        $statement->bindValue(":search_term", "%$search_term%");
        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function getUserInfo($id) {
        $db = DBInit::getInstance();

        $statement = $db->prepare("
        SELECT 
            user.id, 
            email,
            bio,
            username, 
            role.role, 
            joined_at, 
            last_active, 
            profile_picture, 
            country,
            country.name AS country_name,  
            (SELECT COUNT(*) FROM thread WHERE thread.original_poster = user.id) as thread_count, 
            (SELECT COUNT(*) FROM post WHERE post.thread IN (SELECT id FROM thread WHERE thread.original_poster = user.id)) as post_count 
        FROM user, role, country 
        WHERE user.role = role.id AND user.country = country.id AND user.id = :id;");
        $statement->bindValue(":id", $id);
        $statement->execute();

        return $statement->fetch(PDO::FETCH_ASSOC);
    }
}
