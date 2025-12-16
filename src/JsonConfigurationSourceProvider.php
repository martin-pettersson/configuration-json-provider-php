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
     * Directory to resolve configuration sources from.
     *
     * @var string
     */
    private readonly string $rootDirectory;

    /**
     * Create a new service provider instance.
     *
     * @param string $rootDirectory Directory to resolve configuration sources from.
     */
    public function __construct(string $rootDirectory = '')
    {
        $this->rootDirectory = $rootDirectory;
    }

    #[Override]
    public function configure(ContainerBuilderInterface $containerBuilder): void
    {
        /** @var \N7e\ConfigurationSourceProducerRegistryInterface $configurationSourceProducers */
        $configurationSourceProducers = $containerBuilder->build()
            ->get(ConfigurationSourceProducerRegistryInterface::class);

        $configurationSourceProducers->register(new JsonConfigurationSourceProducer($this->rootDirectory));
    }

    /**
     * {@inheritDoc}
     *
     * @phpcsSuppress SlevomatCodingStandard.Functions.UnusedParameter
     */
    #[Override]
    public function load(ContainerInterface $container): void
    {
    }
}
