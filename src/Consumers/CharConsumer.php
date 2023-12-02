<?php

namespace App\Consumers;

use App\Message\ObjectKafkaMessage;
use Psr\Log\LoggerInterface;
use StsGamingGroup\KafkaBundle\Client\Consumer\Message;
use StsGamingGroup\KafkaBundle\Client\Contract\ConsumerInterface;
use StsGamingGroup\KafkaBundle\Client\Producer\ProducerClient;
use StsGamingGroup\KafkaBundle\RdKafka\Context;

class CharConsumer implements ConsumerInterface
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly ProducerClient $producerClient

    ) { }

    const CONSUMER_NAME = 'char_consumer';

    public function consume(Message $message, Context $context)
    {
        $data = $message->getData(); // contains denormalized data from Kafka
        $retryNo = $context->getRetryNo();  // contains retry count in case of a failure

        $this->logger->info('Consumed message', ['data' => $data, 'retryNo' => $retryNo]);

        $message = new ObjectKafkaMessage(
            'Sending from CharConsumer',
            'char_consumer'
        );

        $this->producerClient->produce($message);
        $this->producerClient->flush();
    }

    public function handleException(\Exception $exception, Context $context)
    {
        $this->logger->error($exception->getMessage());
    }

    public function getName(): string
    {
        return self::CONSUMER_NAME;
    }
}