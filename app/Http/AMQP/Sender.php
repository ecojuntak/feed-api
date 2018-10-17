<?php

namespace App\Http\AMQP;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class Sender {

    private $connection;
    private $channel;

    public function __construct() {
        $this->connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
        $this->channel = $this->connection->channel();
        $this->channel->queue_declare('feed_system', false, false, false, false);
    }

    public function send_message($message) {
        $msg = new AMQPMessage($message);
        $this->channel->basic_publish($msg, '', 'feed_system');

        $this->close_connection();
    }

    private function close_connection() {
        $this->channel->close();
        $this->connection->close();
    }
}