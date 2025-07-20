<?php

require_once __DIR__ . "/../controllers/PostController.php";

session_start();
header('Content-Type: application/json');

if (!isset($_SESSION["id"], $_POST["post_id"])) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid input"]);
    exit;
}

$userId = $_SESSION["id"];
$postId = (int) $_POST["post_id"];

$postController = new PostController();
$newLikeCount = $postController->toggleLike($userId, $postId);

echo json_encode(["likes" => $newLikeCount]);