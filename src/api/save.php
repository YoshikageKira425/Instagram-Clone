<?php

require_once __DIR__ . "/../controllers/PostController.php";

session_start();
header('Content-Type: application/json');

if (!isset($_SESSION["id"], $_POST["post_id"])) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid input"]);
    exit;
}

/** @var int $userId */
$userId = $_SESSION["id"];
/** @var int $postId */
$postId = (int) $_POST["post_id"];

/** @var PostController $postController */
$postController = new PostController();
/** @var int $newLikeCount */
$newLikeCount = $postController->toggleSave($userId, $postId);

echo json_encode(["likes" => $newLikeCount]);