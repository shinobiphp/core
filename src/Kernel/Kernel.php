<?php

declare(strict_types=1);

namespace Shinobi\Kernel;

use Shinobi\CSR\Csr;
use Shinobi\Orchestration\Orchestrator;
use Shinobi\Discovery\Engine as DiscoveryEngine;
use Shinobi\Cognition\Cognition;
use Shinobi\Runtime\Interfaces\Runtime as RuntimeInterface;

final class Kernel
{
    public function __construct(
        private readonly Csr $ContextualStateRepository,
        private readonly Orchestrator $orchestrator,
        private readonly DiscoveryEngine $discoveryEngine,
        private readonly Cognition $cognition
    ) {}

    public static function boot(RuntimeInterface $runtime): self
    {
        $csr = Csr::build();

        // register core services
        $csr->addSingleton(Orchestrator::class, new Orchestrator($csr));
        $csr->addSingleton(DiscoveryEngine::class, new DiscoveryEngine($csr));
        $csr->addSingleton(Cognition::class, new Cognition());

        // register runtime
        $csr->addSingleton(RuntimeInterface::class, $runtime);

        $kernel = new self(
            $csr,
            $csr->get(Orchestrator::class),
            $csr->get(DiscoveryEngine::class),
            $csr->get(Cognition::class)
        );

        // optionally let runtime do pre-load tasks
        $runtime->boot($kernel);

        return $kernel;
    }

    public function csr(): Csr
    {
        return $this->ContextualStateRepository;
    }

    public function discovery(): DiscoveryEngine
    {
        return $this->discoveryEngine;
    }

    public function orchestrator(): Orchestrator
    {
        return $this->orchestrator;
    }

    public function cognition(): Cognition
    {
        return $this->cognition;
    }

    public function run(): void
    {
        $runtime = $this->csr()->get(RuntimeInterface::class);
        $runtime->run();
    }
}