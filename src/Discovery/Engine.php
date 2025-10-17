<?php
declare(strict_types=1);

namespace Shinobi\Discovery;

use Shinobi\Discovery\Contracts\Discovered;
use Shinobi\Discovery\Interfaces\Discoverer;

final class Engine
{
    /** @var array<string, Discoverer> */
    private array $discoverers = [];

    public function __construct(private readonly \Shinobi\CSR\Csr $csr) {}

    public function register(string $name, Discoverer $discoverer): self
    {
        $this->discoverers[$name] = $discoverer;
        return $this;
    }

    /** @return iterable<Discovered> */
    public function run(): iterable
    {
        foreach ($this->discoverers as $name => $discoverer) {
            yield from $discoverer->discover();
        }
    }
}
