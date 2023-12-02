<?php

namespace App\Producers;

use App\Message\CharKafkaMessage;
use App\Message\JsonKafkaMessage;
use StsGamingGroup\KafkaBundle\Client\Contract\ProducerInterface;
use StsGamingGroup\KafkaBundle\Client\Producer\Message;

class ObjectProducer implements ProducerInterface
{
    public function produce($data): Message
    {
        /** @var $data JsonKafkaMessage */
        return new Message(json_encode($data));
    }

    public function supports($data): bool
    {
        return $data instanceof JsonKafkaMessage;
    }
}