<?php

require 'vendor/autoload.php';

use Medoo\Medoo;

class Comment
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

    public function addComment($userId, $postId, $commentText)
    {
        return $this->db->insert("comments", [
            "user_id" => $userId,
            "post_id" => $postId,
            "content" => $commentText,
            "created_at" => date("Y-m-d H:i:s")
        ]);
    }

    public function getComments($postId)
    {
        return $this->db->select("comments", [
            "[>]users" => ["user_id" => "id"]
        ], [
            "comments.content",
            "users.username",
            "users.profile_image",
            "users.url"
        ], [
            "post_id" => $postId
        ]);
    }

    public function deleteComment($commentId)
    {
        return $this->db->delete("comments", ["id" => $commentId])->rowCount();
    }

    public function updateComment($commentId, $newText)
    {
        return $this->db->update("comments", ["comment_text" => $newText], ["id" => $commentId])->rowCount();
    }
}
