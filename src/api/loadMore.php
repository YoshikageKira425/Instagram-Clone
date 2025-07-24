<?php

require_once __DIR__ . "/../controllers/PostController.php";

header('Content-Type: text/html');

session_start();

if (!isset($_SESSION["id"], $_POST["offset"], $_POST["limit"])) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid input"]);
    exit;
}

/** @var int $offset */
$offset = $_POST["offset"];

/** @var int $limit */
$limit = $_POST["limit"];

if ($limit > 20) $limit = 20;

/** @var PostController $postController */
$postController = new PostController();

/** @var array $posts */
$posts = $postController->getSomePosts($limit, $offset);

if (empty($posts)) 
    exit;

foreach ($posts as $post) 
    include __DIR__ . '/../component/post.php'; 