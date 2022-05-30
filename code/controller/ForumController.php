<?php

require_once("model/CategoryDB.php");
require_once("model/ThreadDB.php");
require_once("model/UserDB.php");
require_once("model/PostDB.php");
require_once("model/RoleDB.php");

require_once("ViewHelper.php");

class ForumController {
    public static function index() {
        $categories = CategoryDB::getWhere(["parent_category" => 8]);
        foreach ($categories as $key => $category) {
            $categories[$key]["subCategories"] = CategoryDB::getWhere(["parent_category" => $category["id"]]);
            foreach ($categories[$key]["subCategories"] as $key2 => $subCategory) {
                $categories[$key]["subCategories"][$key2]["threadCount"] = CategoryDB::categoryThreadCount($subCategory["id"]);
                $categories[$key]["subCategories"][$key2]["postCount"] = CategoryDB::categoryPostCount($subCategory["id"]);
                $categories[$key]["subCategories"][$key2]["lastPost"] = CategoryDB::categoryLastPost($subCategory["id"]);
            }
        }
        $vars = [
            "categories" => $categories
        ];

        ViewHelper::render("view/forum-index.php", $vars);
    }

    public static function category($id = null) {
        $id = isset($_GET["id"]) ? intval($_GET["id"]) : $id;
        if ($id === null) {
            ViewHelper::redirect(BASE_URL);;
            return;
        }
        $subcategory = CategoryDB::get($id);
        $category = CategoryDB::get($subcategory["parent_category"]);
        $threads = ThreadDB::getWhere(["category" => $id]);
        foreach ($threads as $key => $thread) {
            $threads[$key]["author"] = UserDB::get($thread["original_poster"]);
            $threads[$key]["postCount"] = ThreadDB::postCount($thread["id"]);
            $threads[$key]["lastPost"] = ThreadDB::lastPost($thread["id"]);
        }
        $vars = [
            "category" => $category,
            "subcategory" => $subcategory,
            "threads" => $threads
        ];
        ViewHelper::render("view/forum-category.php", $vars);
    }

    public static function thread($id = null, $errors = []) {
        $id = isset($_GET["id"]) ? intval($_GET["id"]) : $id;
        if ($id === null) {
            ViewHelper::redirect(BASE_URL);;
            return;
        }
        $posts = PostDB::getWhere(["thread" => $id]);
        foreach ($posts as $key => $post) {
            $posts[$key]["author"] = UserDB::get($post["user"]);
            $posts[$key]["author"]["role"] = RoleDB::get($posts[$key]["author"]["role"])["role"];
        }
        $thread = ThreadDB::get($id);
        $subcategory = CategoryDB::get($thread["category"]);
        $category = CategoryDB::get($subcategory["parent_category"]);
        $vars = [
            "category" => $category,
            "subcategory" => $subcategory,
            "thread" => $thread,
            "posts" => $posts,
            "errors" => $errors,
        ];
        ViewHelper::render("view/forum-thread.php", $vars);
    }

    public static function lockThread() {
        $id = isset($_GET["id"]) ? intval($_GET["id"]) : null;
        if ($_SESSION == null || ($_SESSION["role"] != "mod" && $_SESSION["role"] != "admin") || $id === null) {
            ViewHelper::redirect(BASE_URL);
            return;
        }
        ThreadDB::update($id, ["locked" => 1]);
        self::thread();
    }

    public static function unlockThread() {
        $id = isset($_GET["id"]) ? intval($_GET["id"]) : null;
        if ($_SESSION == null || ($_SESSION["role"] != "mod" && $_SESSION["role"] != "admin") || $id === null) {
            ViewHelper::redirect(BASE_URL);
            return;
        }
        ThreadDB::update($id, ["locked" => 0]);
        self::thread();
    }

    public static function deleteThread() {
        $id = isset($_GET["id"]) ? intval($_GET["id"]) : null;
        if ($_SESSION == null || $_SESSION["role"] != "admin" || $id === null) {
            ViewHelper::redirect(BASE_URL);
            return;
        }
        PostDB::deleteWhere(["thread" => $id]);
        ThreadDB::delete($id);
        ViewHelper::redirect(BASE_URL);
    }

    public static function newPost() {
        $errors = [];
        $thread_id = isset($_GET["id"]) ? intval($_GET["id"]) : null;
        $content = isset($_POST["content"]) ? $_POST["content"] : null;
        $submit = isset($_POST["post"]) ? $_POST["post"] : null;
        if ($_SESSION == null || $thread_id === null || $content === null || $submit === null) {
            ViewHelper::redirect(BASE_URL);
            return;
        }
        if (strlen($content) < 10) {
            $errors["post_error"] = "Minimum 10 characters required";
        }
        if (count($errors) > 0) {
            self::thread($thread_id, $errors);
        } else {
            PostDB::insert([
                "thread" => $thread_id,
                "user" => $_SESSION["id"],
                "content" => $content
            ]);
            self::thread($thread_id);
        }
    }

    public static function showNewThreadForm() {
        if ($_SESSION == null || (!isset($_GET["category"]) && !isset($_POST["category"]))) {
            ViewHelper::redirect(BASE_URL);
            return;
        }
        ViewHelper::render("view/forum-new-thread.php");
    }

    public static function newThread() {
        $errors = [];
        $title = isset($_POST["title"]) ? $_POST["title"] : null;
        $content = isset($_POST["content"]) ? $_POST["content"] : null;
        $category = isset($_POST["category"]) ? intval($_POST["category"]) : null;
        $submit = isset($_POST["new-thread"]) ? $_POST["new-thread"] : null;
        if ($_SESSION == null || $title === null || $content === null || $category === null || $submit === null) {
            ViewHelper::redirect(BASE_URL);
            return;
        }
        if (strlen($title) < 5) {
            $errors["title_error"] = "Minimum 5 characters required";
        }
        if (strlen($title) > 100) {
            $errors["title_error"] = "Maximum 30 characters allowed";
        }
        if (strlen($content) < 10) {
            $errors["content_error"] = "Minimum 10 characters required";
        }
        if (strlen($content) > 1000) {
            $errors["title_error"] = "Maximum 1000 characters allowed";
        }
        if (count($errors) > 0) {
            self::showNewThreadForm();
        } else {
            $new_thread_id = ThreadDB::insert([
                "title" => $title,
                "category" => $category,
                "original_poster" => $_SESSION["id"],
            ]);
            PostDB::insert([
                "thread" => $new_thread_id,
                "user" => $_SESSION["id"],
                "content" => $content
            ]);
            ViewHelper::redirect(BASE_URL . "forum/thread?id=" . $new_thread_id);
        }
    }

    public static function adminCategories() {
        $categories = CategoryDB::getWhere(["parent_category" => 8]);
        foreach ($categories as $key => $category) {
            $categories[$key]["subCategories"] = CategoryDB::getWhere(["parent_category" => $category["id"]]);
        }
        $vars = [
            "categories" => $categories
        ];

        ViewHelper::render("view/admin-categories.php", $vars);
    }

    public static function adminCategoriesAdd() {
        $title = isset($_POST["title"]) ? $_POST["title"] : null;
        $parent_category = isset($_POST["parent_category"]) ? intval($_POST["parent_category"]) : null;
        if ($_SESSION == null || $_SESSION["role"] != "admin" || $title === null || $parent_category === null) {
            echo "error";
            return;
        }

        $id = CategoryDB::insert([
            "title" => $title,
            "parent_category" => $parent_category
        ]);
        if ($id) {
            echo $id;
        } else {
            echo "error";
        }
    }

    public static function adminCategoriesRemove() {
        $id = isset($_POST["id"]) ? intval($_POST["id"]) : null;
        if ($_SESSION == null || $_SESSION["role"] != "admin" || $id === null) {
            echo "error";
            return;
        }
        CategoryDB::deleteWhere(["parent_category" => $id]);
        $result = CategoryDB::delete($id);
        if ($result) {
            echo "success";
        } else {
            echo "error";
        }
    }
}