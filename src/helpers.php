<?php

require 'vendor/autoload.php';

use Medoo\Medoo;

function SaveTheImage($file)
{
    $uploadDir = __DIR__ . '/../assets/img/';

    $filename = basename($file['name']);
    $targetFile = $uploadDir . $filename;

    $fileType = mime_content_type($file['tmp_name']);
    $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];

    if (!in_array($fileType, $allowedTypes)) {
        $_SESSION["error"] = 'Invalid file type.';
        return;
    }

    if (move_uploaded_file($file['tmp_name'], $targetFile))
        return "/Instagram_Clone/assets/upload/" . $filename;
    else
        $_SESSION["error"] = "Failed to move uploaded file.";
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
