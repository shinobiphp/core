<?php

declare(strict_types=1);

namespace Shinobi\Discovery\Strategies;

use Shinobi\Discovery\Interfaces\DiscoveryStrategy;
use ReflectionClass;

final class ImplementsInterface implements DiscoveryStrategy
{
    public function __construct(private string $interface) {}

    public function isRelevant(ReflectionClass $class): bool
    {
        return $class->implementsInterface($this->interface);
    }
}
