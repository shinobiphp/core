<?php

declare(strict_types=1);

namespace Shinobi\Runtime;

use Shinobi\Kernel\Kernel;
use Shinobi\Runtime\Interfaces\Runtime as RuntimeInterface;

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class Cli extends Application implements RuntimeInterface
{
    private Kernel $kernel;

    public function boot(Kernel $kernel): void
    {
        $this->kernel = $kernel;

        // auto-register discovered CLI commands
        $discoverers = $kernel->csr()->getByTag('cli_command_discoverer');
        foreach ($discoverers as $discoverer) {
            $discoverer->registerCommands($this);
        }
    }

    public function run(?InputInterface $input = null, ?OutputInterface $output = null): int
    {
        return parent::run($input, $output);
    }
}
