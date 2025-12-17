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
use Override;

/**
 * Provides a JSON configuration source producer.
 */
class JsonConfigurationSourceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritDoc}
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     */
    #[Override]
    public function configure(ContainerBuilderInterface $containerBuilder): void
    {
    }

    #[Override]
    public function load(ContainerInterface $container): void
    {
        /** @var \N7e\ConfigurationSourceProducerRegistryInterface $configurationSourceProducers */
        $configurationSourceProducers = $container->get(ConfigurationSourceProducerRegistryInterface::class);

        /** @var \N7e\RootDirectoryAggregateInterface $rootDirectoryAggregate */
        $rootDirectoryAggregate = $container->get(RootDirectoryAggregateInterface::class);

        $configurationSourceProducers->register(
            new JsonConfigurationSourceProducer($rootDirectoryAggregate->getRootDirectory())
        );
    }
}
