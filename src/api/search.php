<?php

require_once __DIR__ . "/../controllers/PostController.php";
require_once __DIR__ . "/../controllers/UserController.php";

session_start();
header('Content-Type: application/json');

if (!isset($_SESSION["id"], $_POST["query"])) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid input"]);
    exit;
}

/** @var string $query */
$query = $_POST["query"];

/** @var UserController $userController */
$userController = new UserController();

/** @var PostController $postController */
$postController = new PostController();

/** @var array $searchResults */
$posts = $postController->searchPosts($query);
/** @var array $users */
$users = $userController->searchUsers($query);

echo json_encode(["posts" => $posts, "users" => $users]);