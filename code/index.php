<?php
//ini_set('display_errors', 1);
session_start();

require_once("controller/LoginController.php");
require_once("controller/UserController.php");
require_once("controller/ForumController.php");
require_once("model/UserDB.php");

if ($_SESSION != null) {
    UserController::updateLastActive($_SESSION["id"]);
    $user = UserDB::get($_SESSION["id"]);
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
}

define("BASE_URL", $_SERVER["SCRIPT_NAME"] . "/");
define("ASSETS_URL", rtrim($_SERVER["SCRIPT_NAME"], "index.php") . "assets/");

$path = isset($_SERVER["PATH_INFO"]) ? trim($_SERVER["PATH_INFO"], "/") : "";

$urls = [
    "forum" => function () {
        ForumController::index();
    },
    "forum/category" => function() {
        ForumController::category();
    },
    "forum/thread" => function() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            ForumController::newPost();
        } else {
            ForumController::thread();
        }
    },
    "forum/new-thread" => function() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            ForumController::newThread();
        } else {
            ForumController::showNewThreadForm();
        }
    },
    "forum/lock-thread" => function() {
        ForumController::lockThread();
    },
    "forum/unlock-thread" => function() {
        ForumController::unlockThread();
    },
    "forum/delete-thread" => function() {
        ForumController::deleteThread();
    },
    "users" => function() {
        if (isset($_GET["search_term"])) {
            UserController::usersSearch();
        } else {
            UserController::users();
        }
    },
    "user" => function() {
        UserController::user();
    },
    "user/edit" => function() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            UserController::edit();
        } else {
            UserController::showUserEditForm();
        }
    },
    "admin" => function() {
        UserController::adminUsers();
    },
    "admin/users" => function() {
        if (isset($_GET["search_term"])) {
            UserController::adminUsersSearch();
        } else {
            UserController::adminUsers();
        }
    },
    "admin/user/promote" => function() {
        UserController::promoteUser();
    },
    "admin/user/delete" => function() {
        UserController::deleteUser();
    },
    "admin/categories" => function() {
        ForumController::adminCategories();
    },
    "admin/categories/add" => function() {
        ForumController::adminCategoriesAdd();
    },
    "admin/categories/remove" => function() {
        ForumController::adminCategoriesRemove();
    },
    "login" => function() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            LoginController::login();
        } else {
            LoginController::showLoginForm();
        }
    },
    "register" => function() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            LoginController::register();
        } else {
            LoginController::showRegisterForm();
        }
    },
    "logout" => function() {
        LoginController::logout();
    },
    "" => function () {
        ViewHelper::redirect(BASE_URL . "forum");
    },
];

try {
    if (isset($urls[$path])) {
        $urls[$path]();
    } else {
        echo "No controller for '$path'";
    }
} catch (Exception $e) {
    echo "An error occurred: <pre>$e</pre>";
    // ViewHelper::error404();
}