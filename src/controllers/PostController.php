<?php

require __DIR__ . "/../model/Post.php";

class PostController
{
    private $postModel;

    public function __construct()
    {
        $this->postModel = new Post();
    }

    public function insertNewPost($data, $file)
    {
        if (strlen($data["content"]) >= 255) {
            $_SESSION["error"] = "The caption length extended the limit.";
            return;
        }

        if (!isset($file["file"]) || $file["file"]["error"] !== UPLOAD_ERR_OK) {
            $_SESSION["error"] = "No image uploaded or upload failed.";
            return;
        }

        $data["user_id"] = $_SESSION["id"];
        $data["content"] = htmlspecialchars($data["content"]);

        $this->postModel->insertPost($data, $file["file"]);
    }

    public function getPosts($userId)
    {
        return $this->postModel->getPosts($userId);        
    }
}
