<?php

declare(strict_types=1);

namespace Shinobi\CSR;

use Shinobi\Modules\Component;

final class Registry
{
    /** @var Component[] */
    private array $components = [];

    public function register(Component $component): void
    {
        $uri = $component->uri();
        $this->components[$uri] = $component;
    }

    public function get(string $uri): ?Component
    {
        return $this->components[$uri] ?? null;
    }

    /** @return Component[] */
    public function all(): array
    {
        return $this->components;
    }
}
