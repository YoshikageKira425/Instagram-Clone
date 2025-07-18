<?php

require 'vendor/autoload.php';

use Medoo\Medoo;

function SaveTheImage($file)
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
        return;
    }

    if (move_uploaded_file($file['tmp_name'], $targetFile))
        return "/Instagram_Clone/assets/images/upload/" . $filename;
    else {
        $_SESSION["error"] = "Failed to move uploaded file.";
        throw new Exception("Failed to move uploaded file.");
    }
}

function GetCurrentUser()
{
    $db = new Medoo([
        'type' => 'mysql',
        'host' => 'localhost',
        'database' => 'instagram_clone',
        'username' => 'root',
        'password' => ''
    ]);

    return $db->get("users", "*", ["id" => $_SESSION["id"]]);
}

function GetTheUrlValue()
{
    $parts = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
    return $parts[2] ?? "";
}

function GetUserUrl($url)
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

    return $users[0];
}

function GetPost($id)
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

    return $posts[0];
}
