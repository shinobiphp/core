<?php

declare(strict_types=1);

namespace Shinobi\Discovery\Interfaces;

use Shinobi\Discovery\Contracts\Discovered;

use ReflectionClass;

interface Discoverer
{
    public function discover(): void;

    public function register(Discovered $discovered): void;

    /**
     * Decide if a discovered class/file is relevant for this discoverer.
     */
    public function isRelevant(ReflectionClass $class): bool;
}