<?php

declare(strict_types=1);

namespace Shinobi\Discovery;

use Shinobi\Discovery\Contracts\Discovered;
use Shinobi\Discovery\Interfaces\Discoverer;
use Shinobi\Discovery\Interfaces\DiscoveryStrategy;
use Shinobi\Discovery\Traits\IsDiscoverer;

use ReflectionClass;

abstract class BaseDiscoverer implements Discoverer
{
    use IsDiscoverer;

    protected array $scanPaths;

    public function __construct(
        protected readonly DiscoveryStrategy $strategy,
        array $scanPaths = []
    ) {
        $this->scanPaths = $scanPaths ?: [__DIR__ . '/../../..']; // default to top-level src
    }

    public function discover(): void
    {
        foreach ($this->scanPaths as $path) {
            $this->scanPath($path);
        }
    }

    public function isRelevant(ReflectionClass $class): bool
    {
        return $this->strategy->isRelevant($class);
    }

    abstract public function register(Discovered $discovered): void;
}