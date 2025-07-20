<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . "/model/User.php";

use Medoo\Medoo;

function SaveTheImage(array $file): string
{
    $uploadDir = __DIR__ . '/../assets/images/upload/';

    $originalName = preg_replace("/[^A-Za-z0-9\-_\.]/", '_', basename($file['name']));
    $filename = uniqid() . '-' . $originalName;
    $targetFile = $uploadDir . $filename;

    $fileType = mime_content_type($file['tmp_name']);
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

    if (!in_array($fileType, $allowedTypes)) {
        $_SESSION["error"] = 'Invalid file type.';
        throw new Exception("Invalid file type.");
        return "";
    }

    if (move_uploaded_file($file['tmp_name'], $targetFile))
        return "/Instagram_Clone/assets/images/upload/" . $filename;
    else {
        $_SESSION["error"] = "Failed to move uploaded file.";
        throw new Exception("Failed to move uploaded file.");
    }
    return "";
}

function GetCurrentUser(): array
{
    if (isset($_SESSION["id"]) && is_numeric((int)$_SESSION["id"])) {
        return (new User)->findById((int)$_SESSION["id"]);
    }
    return [];
}

function GetTheUrlValue(int $index = 2): string
{
    $parts = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
    return $parts[$index] ?? "";
}

function GetUserUrl(string $url): array
{
    $db = new Medoo([
        'type' => 'mysql',
        'host' => 'localhost',
        'database' => 'instagram_clone',
        'username' => 'root',
        'password' => ''
    ]);

    $users = $db->select("users", "*", ["url" => $url]);

    if (count($users) == 0) {
        header("Location: /Instagram_Clone/notFound.php");
        exit;
    }

    return $users[0] ?? [];
}

function GetPost(int $id): array
{
    $db = new Medoo([
        'type' => 'mysql',
        'host' => 'localhost',
        'database' => 'instagram_clone',
        'username' => 'root',
        'password' => ''
    ]);

    $posts = $db->select("posts", "*", ["id" => $id]);

    if (count($posts) == 0) {
        header("Location: /Instagram_Clone/notFound.php");
        exit;
    }

    return $posts[0] ?? [];
}
