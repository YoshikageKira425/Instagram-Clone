<?php

require_once __DIR__ . "/../controllers/PostController.php";
require_once __DIR__ . "/../helpers.php";

session_start();
header('Content-Type: text/html');

if (!isset($_SESSION["id"], $_POST["offset"], $_POST["limit"])) {
    http_response_code(400);
    exit("Invalid input");
}

/** @var int $offset */
$offset = $_POST["offset"];

/** @var int $limit */
$limit = $_POST["limit"];

/** @var PostController $postController */
$postController = new PostController();

$user = GetCurrentUser();

/** @var array $posts */
$posts = $postController->getSomePosts($limit, $offset);

if (empty($posts)) {
    echo "<p class='text-white text-center'>No more posts to show.</p>";
    exit;
}

foreach ($posts as $post)
    include __DIR__ . '/../componet/post.php'; 