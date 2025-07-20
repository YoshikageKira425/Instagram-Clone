<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use Medoo\Medoo;

final class LikeSave
{
    private Medoo $db;

    public function __construct()
    {
        $this->db = new Medoo([
            'type' => 'mysql',
            'host' => 'localhost',
            'database' => 'instagram_clone',
            'username' => 'root',
            'password' => ''
        ]);
    }

    public function getLikes(int $postId): array
    {
        return $this->db->select("likes", "*", ["post_id" => $postId]);
    }

    public function getLikedPostsByUserId(int $userId): array
    {
        return $this->db->select("likes", ["[>]posts" => ["post_id" => "id"]], ["posts.id", "posts.user_id", "posts.content", "posts.image"], ["likes.user_id" => $userId]) ?? [];
    }

    public function getSaves(int $postId): array
    {
        return $this->db->select("saved", "*", ["post_id" => $postId]);
    }

    public function getSavedPostsByUserId(int $userId): array
    {
        return $this->db->select("saved", ["[>]posts" => ["post_id" => "id"]], ["posts.id", "posts.user_id", "posts.content", "posts.image"], ["saved.user_id" => $userId]) ?? [];
    }

    public function likePost(int $userId, int $postId): void
    {
        if ($this->db->has("likes", ["user_id" => $userId, "post_id" => $postId])) {
            return;
        }

        $this->db->insert("likes", ["user_id" => $userId, "post_id" => $postId]);
    }

    public function savePost(int $userId, int $postId): void
    {
        if ($this->db->has("saved", ["user_id" => $userId, "post_id" => $postId])) {
            return;
        }

        $this->db->insert("saved", ["user_id" => $userId, "post_id" => $postId]);
    }

    public function deleteLike(int $userId, int $postId): int
    {
        return $this->db->delete("likes", ["user_id" => $userId, "post_id" => $postId])->rowCount();
    }

    public function deleteSave(int $userId, int $postId): int
    {
        return $this->db->delete("saved", ["user_id" => $userId, "post_id" => $postId])->rowCount();
    }
}
