<?php

declare(strict_types=1);

require_once __DIR__ . '/../../vendor/autoload.php';

use Medoo\Medoo;

class Messages
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

    public function getAllMessages(int $userId): array
    {
        return $this->db->select("messages", [
            "[>]users" => ["sentBy" => "id"]
        ], [
            "messages.sentBy",
            "messages.sentTo",
            "messages.message",
            "messages.created_at",
            "messages.status",
            "users.id",
            "users.username",
            "users.profile_image"
        ], [
            "OR" => [
                "sentBy" => $userId,
                "sentTo" => $userId
            ],
            "ORDER" => ["created_at" => "DESC"]
        ]) ?? [];
    }

    public function getMessages(int $userId, int $friendId): array
    {
        return $this->db->select("messages", [
            "[>]users" => ["sentBy" => "id"]
        ], [
            "messages.sentTo",
            "messages.sentBy",
            "messages.message",
            "messages.created_at",
            "messages.status",
            "users.username",
            "users.profile_image"
        ], [
            "OR" => [
                "AND #1" => [
                    "messages.sentBy" => $userId,
                    "messages.sentTo" => $friendId
                ],
                "AND #2" => [
                    "messages.sentBy" => $friendId,
                    "messages.sentTo" => $userId
                ]
            ],
            "ORDER" => ["messages.created_at" => "ASC"]
        ]) ?? [];
    }


    public function sendMessage(int $sentById, int $sentToId, string $message): void
    {
        $this->db->insert("messages", [
            "sentBy" => $sentById,
            "sentTo" => $sentToId,
            "message" => $message
        ]);
    }

    public function deleteMessage(int $id): void
    {
        $this->db->delete("messages", ["id" => $id]);
    }

    public function updateMessage(int $id, string $message): void
    {
        $this->db->update("messages", ["message" => $message], ["id" => $id]);
    }

    public function updateMessageStatus(int $id, string $status): void
    {
        $this->db->update("messages", ["status" => $status], ["sentTo" => $id]);
    }
}
