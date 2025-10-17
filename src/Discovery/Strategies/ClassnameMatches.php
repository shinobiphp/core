<?php

declare(strict_types=1);

namespace Shinobi\Discovery\Strategies;

use ReflectionClass;

final class ClassnameMatches extends MatchesPattern
{
    public function __construct(string $pattern)
    {
        parent::__construct($pattern, fn(ReflectionClass $class, string $p) => str_contains($class->getShortName(), $p));
    }
}