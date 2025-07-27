<?php

require_once __DIR__ . "/../controllers/UserController.php";

session_start();
header('Content-Type: application/json');

if (!isset($_SESSION["id"], $_POST["id"])) {
    http_response_code(400);
    echo json_encode(["message" => "Invalid input"]);
    exit;
}

/* @var UserController $userController **/
$userController = new UserController();

$userController->userBan($_POST["id"]);

echo json_encode(["message" => "The user is banned."]);