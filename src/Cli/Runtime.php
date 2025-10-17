<?php
declare(strict_types=1);

namespace Shinobi\Cli;

use Shinobi\Kernel\Kernel;
use Shinobi\CSR\Csr;

use Shinobi\Runtime\Interfaces\Runtime as RuntimeInterface;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Runtime extends Application implements RuntimeInterface
{
    private Kernel $kernel;

    public function setKernel(Kernel $kernel): void
    {
        $this->kernel = $kernel;
    }

    /**
     * Static helper to boot everything and return the CLI runtime instance
     */
    public static function boot(): self
    {
        // 1️⃣ create the runtime first (no kernel yet)
        $runtime = new self('Shinobi CLI', '0.1');

        // 2️⃣ boot kernel with this runtime
        $kernel = Kernel::boot($runtime);

        // 3️⃣ attach kernel back to runtime
        $runtime->setKernel($kernel);

        // 4️⃣ auto-register CLI commands
        $runtime->registerDiscoveredCommands();

        return $runtime;
    }

    /**
     * Auto-register CLI commands discovered by discoverers tagged as 'cli_command_discoverer'
     */
    private function registerDiscoveredCommands(): void
    {
        $csr = $this->kernel->csr();

        $discoverers = $csr->getByTag('cli_command_discoverer');
        foreach ($discoverers as $discoverer) {
            $discoverer->discover(); // run discovery
            foreach ($csr->getByTag('cli_command') as $cmd) {
                $this->add($cmd);
            }
        }
    }
}
