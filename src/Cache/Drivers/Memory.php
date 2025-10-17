<?php
declare(strict_types=1);

namespace Shinobi\Cache\Drivers;

use Shinobi\Cache\Interfaces\Driver as DriverInterface;

final class Memory implements DriverInterface
{
    private array $store = [];

    public function get(string $key): mixed
    {
        return $this->store[$key] ?? null;
    }

    public function set(string $key, mixed $value, ?int $ttl = null): void
    {
        $this->store[$key] = $value;
    }

    public function delete(string $key): void
    {
        unset($this->store[$key]);
    }

    public function clear(): void
    {
        $this->store = [];
    }
}
