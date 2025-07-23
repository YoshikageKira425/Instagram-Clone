<?php

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

require __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . "/src/controllers/MessageController.php";
session_start();

class ChatServer implements MessageComponentInterface
{
    protected \SplObjectStorage $clients;
    protected array $users = [];
    protected MessageController $messageController;

    public function __construct()
    {
        $this->clients = new \SplObjectStorage;
        $this->messageController = new MessageController();
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        $conn->userId = null;
        echo "New connection: {$conn->resourceId}\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg, true);
        if (!$data) return;

        if (!isset($from->userId) && isset($data['from'])) {
            $from->userId = $data['from'];
            $this->users[$data['from']] = $from;
            return;
        }

        $this->messageController->sendMessage(
            intval($data['from']),
            intval($data['to']),
            trim($data['message'])
        );

        $recipientId = intval($data['to']);

        if (isset($this->users[$recipientId])) {
            $this->users[$recipientId]->send($msg);
        }

        foreach ($this->clients as $client) {
            if ($client !== $from) {
                $client->send($msg);
            }
        }

        $from->send($msg);
    }


    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        if (isset($conn->userId)) {
            unset($this->users[$conn->userId]);
        }
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "Error: {$e->getMessage()}\n";
        $conn->close();
    }
}
