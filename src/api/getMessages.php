<?php

require_once __DIR__ . "/../controllers/MessageController.php";
require_once __DIR__ . "/../controllers/UserController.php";
require_once __DIR__ . "/../helpers.php";

session_start();
header('Content-Type: application/json');

if (!isset($_SESSION["id"], $_POST["friend_id"])) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid input"]);
    exit;
}

/** @var array $user */
$user = GetCurrentUser();

/** @var MessageController $messageController */
$messageController = new MessageController();
/** @var array $messages */
$messages = $messageController->getMessages($user["id"], $_POST["friend_id"]);

echo json_encode([
    "messages" => $messages
]);