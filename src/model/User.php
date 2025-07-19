<?php
declare(strict_types=1);

require 'vendor/autoload.php';
require_once  __DIR__ . "/../helpers.php";

use Medoo\Medoo;

final class User
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

    public function insertUser(array $data): void
    {
        $data["profile_image"] = "/Instagram_Clone/assets/images/defaultPic.png";
        $data["join_at"] = date("Y-m-d");
        $data["url"] = preg_replace('/\s+/', '', strtolower(htmlspecialchars($data["username"])));

        $this->db->insert('users', $data);
    }
    public function updatedUser(int $id, array $data, array $file = []): void
    {
        if (!empty($file)) {
            $data["profile_image"] = SaveTheImage($file);
        }
        $data["url"] = preg_replace('/\s+/', '', strtolower(htmlspecialchars($data["username"])));

        $this->db->update('users', $data, ['id' => $id])->rowCount();
    }
    public function deleteUser(int $id): int
    {
        return $this->db->delete('users', ['id' => $id])->rowCount();
    }

    public function followSomeone(int $follow_by, int $follow_to)
    {
        $this->db->insert("followers", ["followed_by" => $follow_by, "followed_to" => $follow_to]);
    }
    public function unFollowSomeone(int $follow_by, int $follow_to)
    {
        $this->db->delete("followers", ["followed_by" => $follow_by, "followed_to" => $follow_to]);
    }
    public function getFollowedBy(int $follow_by): array
    {
        return $this->db->select("followers", "*", ["followed_by" => $follow_by]) ?? [];
    }
    public function getFollowedTo(int $follow_to): array
    {
        return $this->db->select("followers", "*", ["followed_to" => $follow_to]) ?? [];
    }
    public function isFollowedToSomeone(int $follow_by, int $follow_to): bool
    {
        return $this->db->has("followers",  [
            "followed_by" => $follow_by,
            "followed_to" => $follow_to
        ]);
    }

    public function findByEmail(string $email): array
    {
        return $this->db->get('users', '*', ['email' => $email]) ?? [];
    }
    
    public function findById(int $id): array
    {
        return $this->db->get('users', '*', ['id' => $id]) ?? [];
    }
}
