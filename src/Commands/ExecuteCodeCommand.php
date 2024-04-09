<?php

namespace Timberphp\TimberChain\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ExecuteCodeCommand extends Command
{
    protected static $defaultName = 'execute';

    protected static $defaultDescription = 'Execute code in a shell';

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Hello, World!');

        return Command::SUCCESS;
    }
}