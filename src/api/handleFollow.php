<?php

require_once __DIR__ . "/../controllers/UserController.php";

session_start();
header('Content-Type: application/json');


if (!isset($_SESSION["id"]) &&  isset($_POST["friend_id"])) {
    http_response_code(400);
    echo json_encode(["error" => $_SERVER["REQUEST_METHOD"]]);
    exit;
}

/** @var UserController $userController */
$userController = new UserController();

/** @var int $currentUserId */
$currentUserId = (int) $_SESSION["id"];

/** @var int $friendId */
$friendId = (int) $_POST["friend_id"];

/** @var bool $isFollowed */
$isFollowed = $userController->isFollowedToSomeone($currentUserId, $friendId);

/** @var string $action */
$action = $isFollowed ? "unfollowed" : "followed";

$userController->handleFollowAction($action, $currentUserId, $friendId);

echo json_encode(["is_user_followed" => !$isFollowed]);
