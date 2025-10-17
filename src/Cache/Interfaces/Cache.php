<?php

declare(strict_types=1);

namespace Shinobi\Cache\Interfaces;

interface Cache
{
    /**
     * Standard constructor signature for any cache implementation.
     */
    public function __construct(Driver $driver);

    public function get(string $key): mixed;
    public function set(string $key, mixed $value, ?int $ttl = null): void;
    public function delete(string $key): void;
    public function clear(): void;

    /**
     * Factory method to quickly create an instance with a driver.
     */
    public static function make(Driver $driver): self;
}