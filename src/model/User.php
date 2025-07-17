<?php

require 'vendor/autoload.php';
require __DIR__ . "/../helpers.php";

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

        $this->db->insert($this->table, $data);
        return $this->db->id();
    }

    public function updatedUser($id, $data, $file) 
    {
        $data["profile_image"] = SaveTheImage($file);

        return $this->db->update($this->table, $data, ['id' => $id])->rowCount();
    }

    public function deleteUser($id)
    {
        return $this->db->delete($this->table, ['id' => $id])->rowCount();
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
