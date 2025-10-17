<?php

declare(strict_types=1);

namespace Shinobi\Discovery\Strategies;

use Shinobi\Discovery\Interfaces\DiscoveryStrategy;
use ReflectionClass;

class MatchesPattern implements DiscoveryStrategy
{
    /**
     * @param callable|array{ReflectionClass, string}:bool $checker
     *        A callable that receives a ReflectionClass and a pattern string, returns bool.
     */
    public function __construct(
        protected string $pattern,
        protected $checker,
    ) {}

    public function isRelevant(ReflectionClass $class): bool
    {
        return ($this->checker)($class, $this->pattern);
    }
}
