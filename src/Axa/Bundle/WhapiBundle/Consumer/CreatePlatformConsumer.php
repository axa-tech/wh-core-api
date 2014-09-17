<?php

namespace Axa\Bundle\WhapiBundle\Consumer;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class CreatePlatformConsumer implements ConsumerInterface
{
    public function execute(AMQPMessage $msg)
    {
        print_r($msg->body);

        return true;
    }
}
