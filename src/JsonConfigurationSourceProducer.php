<?php

/*
 * Copyright (c) 2025 Martin Pettersson
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace N7e;

use N7e\Configuration\ConfigurationSourceInterface;
use N7e\Configuration\JsonConfigurationSource;
use Override;

/**
 * Produces JSON configuration sources.
 */
class JsonConfigurationSourceProducer implements ConfigurationSourceProducerInterface
{
    /**
     * Directory to resolve configuration sources from.
     *
     * @var string
     */
    private readonly string $rootDirectory;

    /**
     * Create a new configuration source producer instance.
     *
     * @param string $rootDirectory Directory to resolve configuration sources from.
     */
    public function __construct(string $rootDirectory)
    {
        $this->rootDirectory = strlen($rootDirectory) > 0 ? rtrim($rootDirectory, '/') . '/' : $rootDirectory;
    }

    #[Override]
    public function canProduceConfigurationSourceFor(string $url): bool
    {
        $parts = parse_url($url);

        return is_array($parts) &&
               ($parts['scheme'] ?? '') === 'file' &&
               ! array_key_exists('host', $parts) &&
               array_key_exists('path', $parts) &&
               str_ends_with($parts['path'], '.json');
    }

    #[Override]
    public function produceConfigurationSourceFor(string $url): ConfigurationSourceInterface
    {
        return new JsonConfigurationSource($this->rootDirectory . parse_url($url, PHP_URL_PATH));
    }
}
