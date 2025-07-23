<?php

require_once __DIR__ . "/../controllers/UserController.php";

session_start();
header('Content-Type: application/json');

if (!isset($_SESSION["id"], $_POST["delete"]) && $_POST["delete"] === false) {
    http_response_code(400);
    echo json_encode(["error" => "Invalid input"]);
    exit;
}

/** @var UserController $userController */
$userController = new UserController();

$userController->deleteAccount();

echo json_encode(["success" => true]);