<?php

require 'vendor/autoload.php';

use Medoo\Medoo;

class LikeSave
{
    private $db;

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

    public function getLikes($postId)
    {
        return $this->db->select("likes", "*", ["post_id" => $postId]);
    }
    
    public function getSaves($postId)
    {
        return $this->db->select("saved", "*", ["post_id" => $postId]);
    }

    public function likePost($userId, $postId)
    {
        $this->db->insert("likes", ["user_id" => $userId, "post_id" => $postId]);
        return $this->db->id();
    }

    public function savePost($userId, $postId)
    {
        $this->db->insert("saved", ["user_id" => $userId, "post_id" => $postId]);
        return $this->db->id();
    }

    public function deleteLike($userId, $postId)
    {
        return $this->db->delete("likes", ["user_id" => $userId, "post_id" => $postId])->rowCount();
    }

    public function deleteSave($userId, $postId)
    {
        return $this->db->delete("saved", ["user_id" => $userId, "post_id" => $postId])->rowCount();
    }
}