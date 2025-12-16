<?php

/*
 * Copyright (c) 2025 Martin Pettersson
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace N7e;

use N7e\DependencyInjection\ContainerBuilderInterface;
use N7e\DependencyInjection\ContainerInterface;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

#[CoversClass(JsonConfigurationSourceProvider::class)]
class JsonConfigurationSourceProviderTest extends TestCase
{
    private JsonConfigurationSourceProvider $provider;
    private MockObject $containerBuilderMock;
    private MockObject $containerMock;
    private MockObject $registryMock;

    #[Before]
    public function setUp(): void
    {
        $this->provider = new JsonConfigurationSourceProvider();
        $this->containerBuilderMock = $this->getMockBuilder(ContainerBuilderInterface::class)->getMock();
        $this->containerMock = $this->getMockBuilder(ContainerInterface::class)->getMock();
        $this->registryMock = $this->getMockBuilder(ConfigurationSourceProducerRegistryInterface::class)->getMock();

        $this->containerBuilderMock->method('build')
            ->willReturn($this->containerMock);
        $this->containerMock->method('get')
            ->with(ConfigurationSourceProducerRegistryInterface::class)
            ->willReturn($this->registryMock);
    }

    #[Test]
    public function shouldRegisterJsonConfigurationSourceProducer(): void
    {
        $this->registryMock
            ->expects($this->once())
            ->method('register')
            ->with($this->isInstanceOf(JsonConfigurationSourceProducer::class));

        $this->provider->configure($this->containerBuilderMock);
    }
}
