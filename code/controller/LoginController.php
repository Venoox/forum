<?php

require_once "model/UserDB.php";

class LoginController {
    public static function login() {
        $errors = [];
        $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
        if (empty($username)) {
            $errors["username_error"] = "Username is required";
        }
        if (empty($password)) {
            $errors["password_error"] = "Password is required";
        }
        if (count($errors) == 0) {
            $user = UserDB::login($username, $password);
            if ($user) {
                $_SESSION['login'] = 1;
                $_SESSION['id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                switch ($user['role']) {
                    case 1:
                        $_SESSION['role'] = 'admin';
                        break;
                    case 2:
                        $_SESSION['role'] = 'mod';
                        break;
                    case 3:
                        $_SESSION['role'] = 'user';
                        break;
                }
                ViewHelper::redirect(BASE_URL);
            } else {
                self::showLoginForm(["general_error" => "Invalid username or password"]);
            }
        } else {
            self::showLoginForm($errors);
        }

    }

    public static function showLoginForm($errors = []) {
        ViewHelper::render("view/login.php", $errors);
    }

    public static function register() {
        $errors = [];
        $username = filter_var($_POST['username'], FILTER_SANITIZE_STRING);
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $password = filter_var($_POST['password'], FILTER_SANITIZE_STRING);
        $confirm_password = filter_var($_POST['confirm_password'], FILTER_SANITIZE_STRING);
        if (empty($username)) {
            $errors["username_error"] = "Username is required";
        } else if (UserDB::getWhere(["username" => $username])) {
            $errors["username_error"] = "Username already exists";
        } else if (strlen($username) > 50) {
            $errors["username_error"] = "Username must be less than 50 characters";
        }
        if (empty($email)) {
            $errors["email_error"] = "Email is required";
        } else if (UserDB::getWhere(["email" => $email])) {
            $errors["email_error"] = "Email already exists";
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors["email_error"] = "Invalid email";
        } else if (strlen($email) > 50) {
            $errors["email_error"] = "Email must be less than 50 characters";
        }
        if (empty($password)) {
            $errors["password_error"] = "Password is required";
        }
        if (empty($confirm_password)) {
            $errors["confirm_password_error"] = "Confirm password is required";
        }
        if ($password != $confirm_password) {
            $errors["password_error"] = "Password and confirm password must be the same";
        }
        if (strlen($password) < 8) {
            $errors["password_error"] = "Password must be at least 8 characters";
        } else if (strlen($password) > 64) {
            $errors["password_error"] = "Password must be less than 64 characters";
        }
        if (count($errors) == 0) {
            $user = UserDB::register($username, $email, $password);
            if ($user != null) {
                self::showLoginForm();
            } else {
                $errors["general_error"] = "Unexpected error";
                self::showRegisterForm($errors);
            }
        } else {
            self::showRegisterForm($errors);
        }
    }

    public static function showRegisterForm($errors = []) {
        ViewHelper::render("view/register.php", $errors);
    }

    public static function logout() {
        session_destroy();
        ViewHelper::redirect(BASE_URL);
    }
}