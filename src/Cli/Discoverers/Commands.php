<?php

declare(strict_types=1);

namespace Shinobi\Cli\Discoverers\Commands;

use Shinobi\CSR\Csr;
use Shinobi\Discovery\Contracts\Discovered;
use Shinobi\Discovery\Engine as DiscoveryEngine;
use Shinobi\Discovery\Interfaces\Discoverer as DiscovererInterface;
use Shinobi\Discovery\Traits\IsDiscoverer;
use Symfony\Component\Console\Command\Command;
use Shinobi\Discovery\Strategies\ImplementsInterface;

use Shinobi\Discovery\Interfaces\DiscoveryStrategy;

use ReflectionClass;

final class Commands implements DiscovererInterface
{
    use IsDiscoverer;

    protected array $attributes = []; // future attribute-based discovery
    protected array $exclusions = [];
    protected array $scanPaths = [];
    protected DiscoveryStrategy $strategy;

    public function __construct(
        private readonly Csr $csr,
        private readonly DiscoveryEngine $engine,
        ?array $paths = null
    ) {
        $this->scanPaths = $paths ?? [$csr->get('root_path') . '/src/Commands'];

        // strategy: class must implement Symfony Command
        $this->strategy = new ImplementsInterface(Command::class);
    }

    public function discover(): void
    {
        foreach ($this->scanPaths as $path) {
            $files = glob($path . '/*.php');
            foreach ($files as $file) {
                $fqcn = $this->getClassFromFile($file);
                if (!$fqcn || !$this->isRelevant(new \ReflectionClass($fqcn))) {
                    continue;
                }

                $discovered = new Discovered(
                    className: $fqcn,
                    filePath: $file,
                    context: 'cli_command',
                    description: (new \ReflectionClass($fqcn))->getShortName()
                );

                $this->register($discovered);
            }
        }
    }

    public function isRelevant(ReflectionClass $class): bool
    {
        return $this->strategy->isRelevant($class);
    }

    /**
     * Implements the DiscovererInterface register method
     */
    public function register(Discovered $discovered): void
    {
        // register in discovery engine
        $this->engine->register($discovered->className, $this);

        // register in CSR as singleton with CLI command tag
        $this->csr->addSingleton(
            $discovered->className,
            $this->csr->make($discovered->className),
            ['cli_command']
        );
    }

    private function getClassFromFile(string $file): ?string
    {
        $contents = file_get_contents($file);
        if (!preg_match('/namespace\s+(.+?);/i', $contents, $ns)) {
            return null;
        }
        if (!preg_match('/class\s+(\w+)/i', $contents, $cn)) {
            return null;
        }
        return $ns[1] . '\\' . $cn[1];
    }
}
