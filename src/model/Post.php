<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';
require_once  __DIR__ . "/../helpers.php";

use Medoo\Medoo;

final class Post
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

    public function insertPost(array $data, array $file): void
    {
        try {
            $imagePath = SaveTheImage($file);
            $data["image"] = $imagePath;
        } catch (Exception $e) {
            $_SESSION["error"] = $e->getMessage();
            return;
        }

        $data["created_at"] = date("Y-m-d");

        $this->db->insert('posts', $data);
    }
    public function updatePost(int $id, array $data, array $file): void
    {
        $data["image"] = SaveTheImage($file);
        $data["edited_at"] = date("Y-m-d");

        $this->db->update('posts', $data, ['id' => $id])->rowCount();
    }

    public function getAllPosts(): array
    {
        return $this->db->select('posts', ["[>]users" => ["user_id" => "id"]], ["posts.id", "users.username", "users.profile_image", "posts.content", "posts.image"], ['ORDER' => ['created_at' => 'DESC']]) ?? [];
    }

    public function deletePost(int $id): int
    {
        return $this->db->delete('posts', ['id' => $id])->rowCount();
    }
    public function getPostsByUserId(int $userId): array
    {
        return $this->db->select('posts', '*', ['user_id' => $userId]);
    }
    public function getPost(int $id): array
    {
        return $this->db->get('posts', '*', ['id' => $id]);
    }
}
