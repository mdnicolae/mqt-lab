<?php

namespace App\Producers;

use App\Message\CharKafkaMessage;
use StsGamingGroup\KafkaBundle\Client\Contract\ProducerInterface;
use StsGamingGroup\KafkaBundle\Client\Producer\Message;

class CharProducer implements ProducerInterface
{
    public function produce($data): Message
    {
        /** @var $data CharKafkaMessage */
        return new Message($data->getContent(), $data->getKey());
    }

    public function supports($data): bool
    {
        return $data instanceof CharKafkaMessage;
    }
}