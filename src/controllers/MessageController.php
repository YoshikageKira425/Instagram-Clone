<?php

declare(strict_types=1);

require_once __DIR__ . "/../model/Messages.php";

class MessageController
{
    private Messages $messagesModel;

    public function __construct()
    {
        $this->messagesModel = new Messages();
    }

    public function getUsersThatTextYou(): array
    {
        $userId = $_SESSION["id"];
        $friends = $this->messagesModel->getAllMessages($userId);
        $friends = array_filter($friends, function ($message) use ($userId) {
            return $message["sentBy"] !== $userId && $message["sentTo"] === $userId;
        });

        return array_filter($friends, fn($friendId) => $friendId !== 0);
    }

    public function getMessages(int $userId, int $friendId): array
    {
        $this->messagesModel->updateMessageStatus($userId, "seen");

        return $this->messagesModel->getMessages($userId, $friendId);
    }

    public function newMessagesAppeared(int $userId, int $friendId): bool
    {
        $messages = array_filter(
            $this->messagesModel->getMessages($userId, $friendId),
            fn($message) => $message['sentBy'] !== $userId
        );
        if (empty($messages)) {
            return false;
        }
        $lastMessage = end($messages);

        return $lastMessage['status'] !== "seen";        
    }

    public function sendMessage(int $sentById, int $sentToId, string $message): void
    {
        var_dump($sentById, $sentToId, $message);
        exit;
        if (empty($message)) {
            return;
        }
        $this->messagesModel->sendMessage($sentById, $sentToId, $message);
    }

    public function deleteMessage(int $id): void
    {
        $this->messagesModel->deleteMessage($id);
    }

    public function getConversationWith(int $userId, int $friendId): array
    {
        return $this->messagesModel->getMessages($userId, $friendId);
    }
}
