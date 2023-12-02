<?php

namespace App\Controller;

use App\Message\CharKafkaMessage;
use App\Message\JsonKafkaMessage;
use App\Producers\CharProducer;
use StsGamingGroup\KafkaBundle\Client\Producer\ProducerClient;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\InputBag;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;

#[AsController]
class JsonController extends AbstractController
{
    public function __construct(
        private readonly ProducerClient $producerClient
    )
    {
    }

    public function sendJson(
        Request $request,
    ): JsonResponse
    {
        try {
            $content = $request->getPayload();
            $message = new JsonKafkaMessage(
                $content->get('content'),
                $content->get('key'),
            );
            $this->producerClient->produce($message);
            $this->producerClient->flush();

        } catch (\Exception $e) {
            return new JsonResponse(['message' => $e->getMessage()], 400);
        }

        return new JsonResponse(['message' => 'Json sent to Kafka']);
    }
}