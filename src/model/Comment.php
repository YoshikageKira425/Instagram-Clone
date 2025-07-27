<?php
declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use Medoo\Medoo;

final class Comment
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

    public function addComment(int $userId, int $postId, string $commentText): int
    {
        $this->db->insert("comments", [
            "user_id" => $userId,
            "post_id" => $postId,
            "content" => $commentText,
            "created_at" => date("Y-m-d H:i:s")
        ]);
        return (int)$this->db->id();
    }

    public function getComments(int $postId): array
    {
        return $this->db->select("comments", [
            "[>]users" => ["user_id" => "id"]
        ], [
            "comments.id",
            "comments.content",
            "users.username",
            "users.email",
            "users.profile_image",
            "users.url"
        ], [
            "users.status" => "Active",
            "post_id" => $postId
        ]) ?? [];
    }

    public function deleteComment(int $commentId): int
    {
        return $this->db->delete("comments", ["id" => $commentId])->rowCount();
    }

    public function updateComment(int $commentId, string $newText):int
    {
        return $this->db->update("comments", ["comment_text" => $newText], ["id" => $commentId])->rowCount();
    }
}
