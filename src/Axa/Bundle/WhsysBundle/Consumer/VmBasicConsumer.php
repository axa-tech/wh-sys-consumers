<?php

namespace Axa\Bundle\WhsysBundle\Consumer;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

class VmBasicConsumer implements ConsumerInterface
{
    public function execute(AMQPMessage $msg)
    {
        print_r($msg->body);

        return true;
    }
}
