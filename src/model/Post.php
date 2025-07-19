<?php

require 'vendor/autoload.php';
require_once  __DIR__ . "/../helpers.php";

use Medoo\Medoo;

class Post
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

    public function insertPost($data, $file)
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
        return $this->db->id();
    }
    public function updatePost($id, $data, $file)
    {
        $data["image"] = SaveTheImage($file);
        $data["edited_at"] = date("Y-m-d");

        return $this->db->update('posts', $data, ['id' => $id])->rowCount();
    }

    public function deletePost($id)
    {
        return $this->db->delete('posts', ['id' => $id])->rowCount();
    }
    public function getPostsByUserId($userId)
    {
        return $this->db->select('posts', '*', ['user_id' => $userId]);
    }
    public function getPost($id)
    {
        return $this->db->get('posts', '*', ['id' => $id]);
    }
}
