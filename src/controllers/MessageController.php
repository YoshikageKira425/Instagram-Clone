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

    public function sendMessage(int $sentById, int $sentToId, string $message): void
    {
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

    public function newMessage(int $userId, int $friendId): bool
    {
        $allMessage = $this->messagesModel->getAllMessages($userId);
        $allMessage = array_filter($allMessage, function ($m) use ($friendId) {
            return $m["sentBy"] === $friendId;
        });
        $allMessage = array_reverse($allMessage);
        $message = array_pop($allMessage);

        return isset($message) && $message["status"] === 'notseen';
    }

    public function newMessages(int $userId): bool
    {
        $allMessages = $this->messagesModel->getAllMessages($userId);
        $allMessages = array_filter($allMessages, function ($m) use ($userId) {
            return $m["sentTo"] === $userId;
        });

        foreach ($allMessages as $message) {
            if ($message['status'] === 'notseen') {
                return true;
            }
        }

        return false;
    }
}
