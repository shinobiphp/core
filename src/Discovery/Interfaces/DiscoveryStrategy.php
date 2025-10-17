<?php
declare(strict_types=1);

namespace Shinobi\Discovery\Interfaces;

use ReflectionClass;

interface DiscoveryStrategy
{
    /**
     * Determine if a class is relevant.
     */
    public function isRelevant(ReflectionClass $class): bool;
}
