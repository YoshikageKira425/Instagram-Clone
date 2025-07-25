<?php

require_once __DIR__ . "/../controllers/PostController.php";
require_once __DIR__ . "/../controllers/UserController.php";

session_start();
header('Content-Type: application/json');

if (!isset($_SESSION["id"], $_POST["content"], $_POST["id"])) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid input"]);
    exit;
}

/** @var PostController $postController */
$postController = new PostController();
/** @var UserController $userController */
$userController = new UserController();

/** @var array $user */
$user = $userController->getUserById($_SESSION["id"]);

/** @var int $id */
$id = (int)$_POST["id"];

/** @var string $content */
$content = $_POST["content"];

/** @var int $commentId */
$commentId = $postController->insertComment($user["id"], $id, $content);

echo json_encode(["comment" => $content, "commentId" => $commentId, "user" => [
    "id" => $user["id"],
    "url" => $user["url"],
    "username" => $user["username"],
    "profile_image" => $user["profile_image"]
], "post" => $id]);