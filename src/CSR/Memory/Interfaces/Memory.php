<?php
declare(strict_types=1);

namespace Shinobi\CSR\Memory\Interfaces;

interface Memory
{
    public function set(string $key, mixed $value): void;

    public function get(string $key, mixed $default = null): mixed;

    public function has(string $key): bool;

    public function delete(string $key): void;

    public function all(): array;
}
