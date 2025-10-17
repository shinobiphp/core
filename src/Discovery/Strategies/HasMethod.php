<?php
declare(strict_types=1);

namespace Shinobi\Discovery\Strategies;

use Shinobi\Discovery\Interfaces\DiscoveryStrategy;
use ReflectionClass;

final class HasMethod implements DiscoveryStrategy
{
    public function __construct(private string $methodName) {}

    public function isRelevant(ReflectionClass $class): bool
    {
        return $class->hasMethod($this->methodName);
    }
}
