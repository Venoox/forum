<?php

require_once 'model/UserDB.php';
require_once 'model/CountryDB.php';

class UserController {
    public static function users() {
        $users = UserDB::getUsersInfo();
        $vars = [
            "users" => $users
        ];
        ViewHelper::render("view/users-index.php", $vars);
    }

    public static function usersSearch() {
        $search_term = isset($_GET["search_term"]) ? $_GET["search_term"] : "";
        $users = UserDB::getUsersInfo($search_term);
        $vars = [
            "users" => $users
        ];
        ViewHelper::render("view/ajax-users-template.php", $vars);
    }

    public static function user() {
        $id = isset($_GET["id"]) ? intval($_GET["id"]) : null;
        if ($id == null) {
            ViewHelper::redirect(BASE_URL);
            return;
        }
        $user = UserDB::getUserInfo($id);
        $threads = ThreadDB::getWhere(["original_poster" => $id]);
        foreach ($threads as $key => $thread) {
            $threads[$key]["lastPost"] = ThreadDB::lastPost($thread["id"]);
        }
        $vars = [
            "user" => $user,
            "threads" => $threads
        ];

        ViewHelper::render("view/user-profile.php", $vars);
    }

    public static function updateLastActive($id) {
        UserDB::update($id, ["last_active" => date("Y-m-d H:i:s")]);
    }

    public static function showUserEditForm($errors = []) {
        if ($_SESSION == null) {
            ViewHelper::redirect(BASE_URL);
            return;
        }
        $user = UserDB::getUserInfo($_SESSION["id"]);
        $countries = CountryDB::getAll();
        $vars = [
            "user" => $user,
            "errors" => $errors,
            "countries" => $countries
        ];
        ViewHelper::render("view/user-edit.php", $vars);
    }

    public static function edit() {
        if ($_SESSION == null) {
            ViewHelper::redirect(BASE_URL);
            return;
        }
        $errors = [];
        $id = $_SESSION["id"];
        $user = UserDB::get($id);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
        $confirm_password = filter_var($_POST['confirm_password'], FILTER_SANITIZE_STRING);
        $country = filter_var($_POST['country'], FILTER_SANITIZE_NUMBER_INT);
        $bio = filter_var($_POST['bio'], FILTER_SANITIZE_STRING);
        $file_path = "";
        $values = [];

        if ($_FILES["profile_picture"] != null) {
            $file_path = "assets/profile_pictures/" . date("Y-m-dTH:i:s") . "-" . basename($_FILES['profile_picture']['name']);
            move_uploaded_file($_FILES['profile_picture']['tmp_name'], $file_path);
            $values["profile_picture"] = $file_path;
        }

        if (empty($email)) {
            $errors["email_error"] = "Email is required";
        } else if ($user["email"] != $email && UserDB::getWhere(["email" => $email])) {
            $errors["email_error"] = "Email already exists";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors["email_error"] = "Invalid email address";
        } else if (strlen($email) > 50) {
            $errors["email_error"] = "Email must be less than 50 characters";
        } else {
            $values["email"] = $email;
        }
        if (!empty($password)) {
            if (empty($confirm_password)) {
                $errors["confirm_password_error"] = "Confirm password is required";
            } else if ($password != $confirm_password) {
                $errors["password_error"] = "Password and confirm password must be the same";
            } else if (strlen($password) < 8) {
                $errors["password_error"] = "Password must be at least 8 characters";
            } else if (strlen($password) > 64) {
                $errors["password_error"] = "Password must be less than 64 characters";
            } else {
                $values["password"] = password_hash($password, PASSWORD_BCRYPT);
            }
        }
        /*if (!empty($country)) {
            $values["country"] = $country;
        }*/
        if (!empty($bio)) {
            $values["bio"] = $bio;
        }
        if (count($errors) == 0) {
            $success = UserDB::update($id, $values);
            if ($success != null) {
                ViewHelper::redirect(BASE_URL . "user?id=" . $id);
            } else {
                $errors["general_error"] = "Unexpected error";
                self::showUserEditForm($errors);
            }
        } else {
            self::showUserEditForm($errors);
        }
    }

    public static function adminUsers() {
        if ($_SESSION == null || $_SESSION["role"] != "admin") {
            ViewHelper::redirect(BASE_URL);
            return;
        }
        $users = UserDB::getUsersInfo();
        $roles = RoleDB::getAll();
        $vars = [
            "users" => $users,
            "roles" => $roles
        ];
        ViewHelper::render("view/admin-users.php", $vars);
    }

    public static function adminUsersSearch() {
        if ($_SESSION == null || $_SESSION["role"] != "admin") {
            ViewHelper::redirect(BASE_URL);
            return;
        }
        $search_term = isset($_GET["search_term"]) ? $_GET["search_term"] : "";
        $users = UserDB::getUsersInfo($search_term);
        $roles = RoleDB::getAll();
        $vars = [
            "users" => $users,
            "roles" => $roles
        ];
        ViewHelper::render("view/ajax-admin-users-template.php", $vars);
    }

    public static function promoteUser() {
        if ($_SESSION == null || $_SESSION["role"] != "admin") {
            echo "error";
            return;
        }
        $id = $_POST["id"];
        $role = $_POST["role"];
        $success = UserDB::update($id, ["role" => $role]);
        if ($success != null) {
            echo "success";
        } else {
            echo "error";
        }
    }

    public static function deleteUser() {
        if ($_SESSION == null || $_SESSION["role"] != "admin") {
            echo "error";
            return;
        }
        $id = $_POST["id"];
        PostDB::deleteWhere(["user" => $id]);
        ThreadDB::deleteWhere(["original_poster" => $id]);
        $success = UserDB::delete($id);
        if ($success != null) {
            echo "success";
        } else {
            echo "error";
        }
    }
}