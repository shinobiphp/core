<?php
declare(strict_types=1);

namespace Shinobi\Discovery\Strategies;

use Shinobi\Discovery\Interfaces\DiscoveryStrategy;
use ReflectionClass;

final class HasProperty implements DiscoveryStrategy
{
    public function __construct(private string $propertyName) {}

    public function isRelevant(ReflectionClass $class): bool
    {
        return $class->hasProperty($this->propertyName);
    }
}
