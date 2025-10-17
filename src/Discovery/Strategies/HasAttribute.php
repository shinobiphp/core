<?php
declare(strict_types=1);

namespace Shinobi\Discovery\Strategies;

use Shinobi\Discovery\Interfaces\DiscoveryStrategy;
use ReflectionClass;

final class HasAttribute implements DiscoveryStrategy
{
    public function __construct(
        private array $includeAttributes = ['Shinobi\Discovery\Attributes\Discoverable'],
        private array $excludeAttributes = ['Shinobi\Discovery\Attributes\Undiscoverable'],
    ) {}

    public function isRelevant(ReflectionClass $class): bool
    {
        if ($class->isAbstract()) return false;

        foreach ($this->excludeAttributes as $attr) {
            if (!empty($class->getAttributes($attr))) return false;
        }

        if (empty($this->includeAttributes)) return true;

        foreach ($this->includeAttributes as $attr) {
            if (!empty($class->getAttributes($attr))) return true;
        }

        return false;
    }
}
