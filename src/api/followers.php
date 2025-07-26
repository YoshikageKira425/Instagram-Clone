<?php

require_once __DIR__ . "/../controllers/UserController.php";

session_start();
header('Content-Type: application/json');

if (!isset($_SESSION["id"], $_POST["action"], $_POST["id"])) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid input"]);
    exit;
}

/** @var UserController $userController */
$userController = new UserController();

/** @var string $action */
$action = $_POST["action"];

/** @var int $id */
$id = (int) $_POST["id"];

/** @var int $currentUserId */
$currentUserId = (int) $_SESSION["id"];

switch ($action) {
    case "followers":
        $rawUsers = $userController->getFollowedTo($id);
        break;
    case "following":
        $rawUsers = $userController->getFollowedBy($id);
        break;
    default:
        http_response_code(400);
        echo json_encode(["error" => "Unknown action"]);
        exit;
}

$usersWithStatus = $userController->attachFollowStatus($rawUsers, $currentUserId);

echo json_encode(["users" => $usersWithStatus]);