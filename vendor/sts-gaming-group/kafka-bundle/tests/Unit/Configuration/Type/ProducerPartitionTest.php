<?php

declare(strict_types=1);

namespace StsGamingGroup\KafkaBundle\Tests\Unit\Configuration\Type;

use StsGamingGroup\KafkaBundle\Configuration\Contract\ConfigurationInterface;
use StsGamingGroup\KafkaBundle\Configuration\Type\ProducerPartition;

class ProducerPartitionTest extends AbstractConfigurationTest
{
    protected function getConfiguration(): ConfigurationInterface
    {
        return new ProducerPartition();
    }

    protected function getValidValues(): array
    {
        return [-1, '1', 2];
    }

    protected function getInvalidValues(): array
    {
        return [1.51, '1.51', '', [], null, new \stdClass(), false, true];
    }
}
