<?php
declare(strict_types=1);

namespace Shinobi\CSR\Memory;

use Shinobi\CSR\Memory\Interfaces\Memory as MemoryContract;

final class InMemory implements MemoryContract
{
    private array $store = [];

    public function set(string $key, mixed $value): void
    {
        $this->store[$key] = $value;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->store[$key] ?? $default;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->store);
    }

    public function delete(string $key): void
    {
        unset($this->store[$key]);
    }

    public function all(): array
    {
        return $this->store;
    }
}
