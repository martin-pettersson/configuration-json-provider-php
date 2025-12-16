<?php

/*
 * Copyright (c) 2025 Martin Pettersson
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace N7e;

use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(JsonConfigurationSourceProducer::class)]
class JsonConfigurationSourceProducerTest extends TestCase
{
    private JsonConfigurationSourceProducer $producer;

    #[Before]
    public function setUp(): void
    {
        $this->producer = new JsonConfigurationSourceProducer(__DIR__);
    }

    #[Test]
    public function shouldHandleJsonFileSources(): void
    {
        $this->assertTrue($this->producer->canProduceConfigurationSourceFor('file:configuration.json'));

        $this->assertFalse($this->producer->canProduceConfigurationSourceFor('file:configuration.yml'));
        $this->assertFalse($this->producer->canProduceConfigurationSourceFor('file://host/configuration.json'));
        $this->assertFalse($this->producer->canProduceConfigurationSourceFor('http://configuration.yml'));
    }

    #[Test]
    public function shouldProduceConfigurationSourceWithRelativeFilePath(): void
    {
        $configurationSource = $this->producer->produceConfigurationSourceFor('file:fixtures/configuration.json');

        $this->assertEquals(['key' => 'value'], $configurationSource->load());
    }
}
