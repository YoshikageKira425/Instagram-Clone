<?php

declare(strict_types=1);

require_once __DIR__ . "/../model/Post.php";
require_once __DIR__ . "/../model/User.php";
require_once __DIR__ . "/../model/LikeSave.php";
require_once __DIR__ . "/../model/Comment.php";

class PostController
{
    private Post $postModel;
    private User $userModel;
    private LikeSave $likeSaveModel;
    private Comment $commentModel;

    public function __construct()
    {
        $this->postModel = new Post();
        $this->userModel = new User();
        $this->likeSaveModel = new LikeSave();
        $this->commentModel = new Comment();
    }

    public function insertNewPost(array $data, array $file): void
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

    public function updatePost(int $id, array $data, array $file): void
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

    public function searchPosts(string $query): array
    {
        if (strlen($query) < 3) {
            return [];
        }

        $query = htmlspecialchars($query);
        return $this->postModel->searchPosts($query);
    }

    public function getSomePosts(int $limit, int $offset = 0): array
    {
        return $this->postModel->getSomePosts($limit, $offset);
    }

    public function insertComment(int $user_id, int $post_id, string $content): int
    {
        return $this->commentModel->addComment($user_id, $post_id, $content);
    }

    public function getComments(int $postId): array
    {
        return $this->commentModel->getComments($postId);
    }

    public function toggleLike(int $userId, int $postId): int
    {
        if ($this->isLiked($postId)) {
            $this->likeSaveModel->deleteLike($userId, $postId);
        } else {
            $this->likeSaveModel->likePost($userId, $postId);
        }

        return $this->GetLikesCount($postId);
    }

    public function toggleSave(int $userId, int $postId): int
    {
        if ($this->isSaved($postId)) {
            $this->likeSaveModel->deleteSave($userId, $postId);
        } else {
            $this->likeSaveModel->savePost($userId, $postId);
        }

        return $this->GetLikesCount($postId);
    }

    public function getPostCount(): int
    {
        return count($this->postModel->getAllPosts());
    }

    public function GetLikesCount(int $postId): int
    {
        $likes = $this->likeSaveModel->getLikes($postId);
        return count($likes);
    }

    public function isLiked(int $postId): bool
    {
        $likes = $this->likeSaveModel->getLikes($postId);
        foreach ($likes as $like) {
            if ($like["user_id"] == $_SESSION["id"]) {
                return true;
            }
        }
        return false;
    }

    public function isSaved(int $postId): bool
    {
        $saves = $this->likeSaveModel->getSaves($postId);
        foreach ($saves as $save) {
            if ($save["user_id"] == $_SESSION["id"]) {
                return true;
            }
        }
        return false;
    }

    public function getLikedPosts(int $userId): array
    {
        return $this->likeSaveModel->getLikedPostsByUserId($userId);
    }

    public function getSavedPosts(int $userId): array
    {
        return $this->likeSaveModel->getSavedPostsByUserId($userId);
    }

    public function getPosts(int $userId): array
    {
        return $this->postModel->getPostsByUserId($userId);
    }

    public function getUserPosts(int $userId): array
    {
        return $this->userModel->findById($userId);
    }

    function GetPost(int $id): array
    {
        $posts = $this->postModel->getPost($id);

        if (count($posts) == 0) {
            header("Location: /Instagram_Clone/notFound.php");
            exit;
        }

        return $posts[0];
    }

    public function getAllPostsForAdmin(): array
    {
        return $this->postModel->getAllPostsForAdmin();        
    }
}
