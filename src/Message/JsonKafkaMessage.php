<?php

namespace App\Message;

class JsonKafkaMessage
{
    public function __construct(
        public readonly string $content,
        public readonly string $key
    ){
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getKey(): string
    {
        return $this->key;
    }
}
