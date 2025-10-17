<?php
declare(strict_types=1);

namespace Shinobi\Cli\Commands;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

// the name of the command is what users type after "php bin/console"
#[AsCommand(name: 'node:start')]
class StartNode
{
    public function __invoke(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('<info>Starting Node...</info>');
        return Command::SUCCESS;
    }
}