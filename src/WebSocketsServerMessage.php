<?php

namespace Gabeta\CustomSmsChannels;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class WebSocketsServerMessage implements MessageComponentInterface
{
    protected $clients;

    public function __construct() 
    {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn) 
    {
        $this->clients->attach($conn);

        echo "New connexion \n";
    }

    public function onMessage(ConnectionInterface $from, $msg) 
    {
        foreach ($this->clients as $client) {
            if ($from != $client) {
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) 
    {
        $this->clients->detach($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e) 
    {
        $conn->close();
    }
}
