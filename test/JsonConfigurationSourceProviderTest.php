<?php

/*
 * Copyright (c) 2025 Martin Pettersson
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace N7e;

use JakubOnderka\PhpParallelLint\RunTimeException;
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
    private MockObject $containerMock;
    private MockObject $registryMock;
    private MockObject $rootDirectoryAggregateMock;

    #[Before]
    public function setUp(): void
    {
        $this->provider = new JsonConfigurationSourceProvider();
        $this->containerMock = $this->getMockBuilder(ContainerInterface::class)->getMock();
        $this->registryMock = $this->getMockBuilder(ConfigurationSourceProducerRegistryInterface::class)->getMock();
        $this->rootDirectoryAggregateMock = $this->getMockBuilder(RootDirectoryAggregateInterface::class)->getMock();

        $this->containerMock->method('get')
            ->willReturnCallback(fn($identifier) => match ($identifier) {
                ConfigurationSourceProducerRegistryInterface::class => $this->registryMock,
                RootDirectoryAggregateInterface::class => $this->rootDirectoryAggregateMock,
                default => throw new RunTimeException("No mock found for {$identifier}")
            });
    }

    #[Test]
    public function shouldRegisterJsonConfigurationSourceProducer(): void
    {
        $this->registryMock
            ->expects($this->once())
            ->method('register')
            ->with($this->isInstanceOf(JsonConfigurationSourceProducer::class));

        $this->provider->load($this->containerMock);
    }
}
