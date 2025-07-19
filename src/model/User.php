<?php

require 'vendor/autoload.php';
require_once  __DIR__ . "/../helpers.php";

use Medoo\Medoo;

class User
{
    private $table = 'users';
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

    public function insertUser($data)
    {
        $data["profile_image"] = "/Instagram_Clone/assets/images/defaultPic.png";
        $data["join_at"] = date("Y-m-d");
        $data["url"] = preg_replace('/\s+/', '', strtolower(htmlspecialchars($data["username"])));

        $this->db->insert($this->table, $data);
        return $this->db->id();
    }
    public function updatedUser($id, $data, $file)
    {
        $data["profile_image"] = SaveTheImage($file);
        $data["url"] = preg_replace('/\s+/', '', strtolower(htmlspecialchars($data["username"])));

        return $this->db->update($this->table, $data, ['id' => $id])->rowCount();
    }
    public function deleteUser($id)
    {
        return $this->db->delete($this->table, ['id' => $id])->rowCount();
    }

    public function followSomeone($follow_by, $follow_to)
    {
        $this->db->insert("followers", ["followed_by" => $follow_by, "followed_to" => $follow_to]);
    }
    public function unFollowSomeone($follow_by, $follow_to)
    {
        $this->db->delete("followers", ["followed_by" => $follow_by, "followed_to" => $follow_to]);
    }
    public function getFollowedBy($follow_by)
    {
        return $this->db->select("followers", "*", ["followed_by" => $follow_by]) ?? [];
    }
    public function getFollowedTo($follow_to)
    {
        return $this->db->select("followers", "*", ["followed_to" => $follow_to]) ?? [];
    }
    public function isFollowedToSomeone($follow_by, $follow_to)
    {
        return $this->db->has("followers",  [
            "followed_by" => $follow_by,
            "followed_to" => $follow_to
        ]);
    }

    public function findByEmail($email)
    {
        return $this->db->get($this->table, '*', ['email' => $email]);
    }
    public function findById($id)
    {
        return $this->db->get($this->table, '*', ['id' => $id]);
    }
}
