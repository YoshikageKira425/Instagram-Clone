<?php

require_once __DIR__ . "/../model/Post.php";
require_once __DIR__ . "/../model/User.php";
require_once __DIR__ . "/../model/LikeSave.php";
require_once __DIR__ . "/../model/Comment.php";

class PostController
{
    private $postModel;
    private $userModel;
    private $likeSaveModel;
    private $commentModel;

    public function __construct()
    {
        $this->postModel = new Post();
        $this->userModel = new User();
        $this->likeSaveModel = new LikeSave();
        $this->commentModel = new Comment();
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

    public function updatePost($id, $data, $file)
    {
        if (strlen($data["content"]) >= 255) {
            $_SESSION["error"] = "The caption length extended the limit.";
            return;
        }

        if (!isset($file["file"]) || $file["file"]["error"] !== UPLOAD_ERR_OK) {
            $_SESSION["error"] = "No image uploaded or upload failed.";
            return;
        }

        $data["content"] = htmlspecialchars($data["content"]);
        $this->postModel->updatePost($id, $data, $file["file"]);
    }

    public function insertComment($user_id, $post_id, $content) 
    {
        $this->commentModel->addComment($user_id, $post_id, $content);
    }

    public function getComments($postId)
    {
        return $this->commentModel->getComments($postId);
    }

    public function handleLikeAndSave($postId, $action)
    {
        if ($action === 'like')
            $this->likeSaveModel->likePost($_SESSION["id"], $postId);
        elseif ($action === 'save')
            $this->likeSaveModel->savePost($_SESSION["id"], $postId);
        elseif ($action === 'unlike')
            $this->likeSaveModel->deleteLike($_SESSION["id"], $postId);
        elseif ($action === 'unsave')
            $this->likeSaveModel->deleteSave($_SESSION["id"], $postId);
    }

    public function GetLikesCount($postId)
    {
        $likes = $this->likeSaveModel->getLikes($postId);
        return count($likes);
    }

    public function isLiked($postId)
    {
        $likes = $this->likeSaveModel->getLikes($postId);
        foreach ($likes as $like) {
            if ($like["user_id"] == $_SESSION["id"]) {
                return true;
            }
        }
        return false;
    }

    public function isSaved($postId)
    {
        $saves = $this->likeSaveModel->getSaves($postId);
        foreach ($saves as $save) {
            if ($save["user_id"] == $_SESSION["id"]) {
                return true;
            }
        }
        return false;
    }

    public function getPosts($userId)
    {
        return $this->postModel->getPostsByUserId($userId);
    }

    public function getUserPosts($userId)
    {
        return $this->userModel->findById($userId);
    }

    function GetPost($id)
    {
        $posts = $this->postModel->getPost($id);

        if (count($posts) == 0) {
            header("Location: /Instagram_Clone/notFound.php");
            exit;
        }

        return $posts[0];
    }
}
