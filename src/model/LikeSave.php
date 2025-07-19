<?php

require 'vendor/autoload.php';

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
    
    public function getSaves(int $postId): array
    {
        return $this->db->select("saved", "*", ["post_id" => $postId]);
    }

    public function likePost(int $userId, int $postId): void
    {
        $this->db->insert("likes", ["user_id" => $userId, "post_id" => $postId]);
    }

    public function savePost(int $userId, int $postId): void
    {
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