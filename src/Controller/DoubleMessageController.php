<?php

namespace App\Controller;

use App\Message\CharKafkaMessage;
use App\Message\JsonKafkaMessage;
use App\Producers\CharProducer;
use Enqueue\RdKafka\RdKafkaConnectionFactory;
use StsGamingGroup\KafkaBundle\Client\Producer\ProducerClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

#[AsController]
class DoubleMessageController extends AbstractController
{
    public function __construct(
    )
    {
    }

    public function send(
        Request $request,
    ): JsonResponse
    {
        $content = $request->getPayload();

        $message1 = $content->get('message-1');
        $message2 = $content->get('message-2');


        $connectionFactory = new RdKafkaConnectionFactory(['global' => ['metadata.broker.list' => 'localhost:9092']]);
        $context = $connectionFactory->createContext();

        $topic1 = $context->createTopic('topic1');
        $message1 = $context->createMessage($message1);
        $context->createProducer()->send($topic1, $message1);

        $topic2 = $context->createTopic('topic2');
        $message2 = $context->createMessage($message2);
        $context->createProducer()->send($topic2, $message2);
    }
}