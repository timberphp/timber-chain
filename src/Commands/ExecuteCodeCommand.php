<?php

namespace Timberphp\TimberChain\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\StreamOutput;
use Timberphp\TimberChain\CodeRunner;

class ExecuteCodeCommand extends Command
{
    protected static $defaultName = 'execute';

    protected static $defaultDescription = 'Execute code in a shell';

    protected function configure()
    {
        return $this
            ->addOption('target', null, InputOption::VALUE_OPTIONAL, 'The target path to execute code in')
            ->addOption('code', null, InputOption::VALUE_OPTIONAL, 'The code to execute')
            ->addOption('base64Code', null, InputOption::VALUE_OPTIONAL, 'The code to execute in base64 format');
    }

    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if ($input->getOption('code') && $input->getOption('base64Code')) {
            throw new \InvalidArgumentException('You can only provide one of the code or base64Code options');
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $runner = new CodeRunner('buffered');

        $result = $runner
            ->bootstrapAt($input->getOption('target'))
            ->execute(
                $input->getOption('code') ?: base64_decode(trim($input->getOption('base64Code')))
            );

        $output->write($result);

        return Command::SUCCESS;
    }
}