<?php

declare(strict_types=1);

namespace Shinobi\Discovery\Discoverers;

use Shinobi\Discovery\BaseDiscoverer;
use Shinobi\Discovery\Contracts\Discovered;
use Shinobi\Discovery\Engine;
use Shinobi\Discovery\Strategies\ImplementsInterface;

use Shinobi\Discovery\Interfaces\Discoverer as DiscovererInterface;

final class Discoverers extends BaseDiscoverer
{
    public function __construct(private readonly Engine $engine)
    {
        parent::__construct(
            strategy: new ImplementsInterface(DiscovererInterface::class)
        );
    }

    public function register(Discovered $discovered): void
    {
        // Instantiate the discoverer class and register it in Engine
        $className = $discovered->className;
        $instance = new $className($this->engine);
        $this->engine->register($className, $instance);
    }
}