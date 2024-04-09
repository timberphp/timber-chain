<?php

namespace Timberphp\TimberChain\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Timberphp\TimberChain\CodeRunner;

class ExecuteCodeCommand extends Command
{
    protected static $defaultName = 'execute';

    protected static $defaultDescription = 'Execute code in a shell';

    protected function configure()
    {
        return $this
            ->addArgument('code', InputArgument::REQUIRED, 'The code to execute')
            ->addOption('target', null, InputOption::VALUE_OPTIONAL, 'The target path to execute code in')
            ->addOption('base64', null, InputOption::VALUE_OPTIONAL, 'The code to execute in base64 format', false)
            ->addOption('stream', null, InputOption::VALUE_OPTIONAL, 'The output mode (stream or buffered)', false);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $runner = new CodeRunner($input->getOption('stream') !== false ? 'stream' : 'buffered');

        $code = $input->getOption('base64') ? base64_decode(trim($input->getOption('base64'))) : $input->getArgument('code');

        $result = $runner
            ->bootstrapAt($input->getOption('target'))
            ->execute($code);

        $output->write($result);

        return Command::SUCCESS;
    }
}