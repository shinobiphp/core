<?php
declare(strict_types=1);

namespace Shinobi\Cognition\Context;

use Shinobi\Cognition\Context\Interfaces\Context as ContextContract;

final class SimpleContext implements ContextContract
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

    public function all(): array
    {
        return $this->store;
    }
}
