<?php

declare(strict_types=1);

namespace Shinobi\Cache;

use Shinobi\Cache\Interfaces\Cache as CacheInterface;
use Shinobi\Cache\Interfaces\Driver as CacheDriver;

final class Cache implements CacheInterface
{
    public function __construct(private readonly CacheDriver $driver) {}

    public function get(string $key): mixed
    {
        return $this->driver->get($key);
    }

    public function set(string $key, mixed $value, ?int $ttl = null): void
    {
        $this->driver->set($key, $value, $ttl);
    }

    public function delete(string $key): void
    {
        $this->driver->delete($key);
    }

    public function clear(): void
    {
        $this->driver->clear();
    }

    public static function make(CacheDriver $driver): self
    {
        return new self($driver);
    }
}