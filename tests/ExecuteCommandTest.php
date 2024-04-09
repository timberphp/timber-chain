<?php

namespace BangNokia\Psycho\Tests;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Process\Process;

class ExecuteCommandTest extends TestCase
{
    public function testCallFromOtherProcessWithRawOutput()
    {
        $entry = __DIR__.'/../chain';
        $target = __DIR__.'/fixtures/foo';
        $phpCode = 'foo()';

        $command = <<<BASH
php $entry execute --target=$target "{$phpCode}"
BASH;

        $output = shell_exec($command);

        $this->assertEquals("'bar'", trim($output));
    }

    public function testCanPassMultipleLinesOfCode()
    {
        $entry = __DIR__.'/../index.php';
        $target = __DIR__;
        $phpCode = base64_encode(<<<'EOF'
$name = 'tinker';
$greeting = 'hello '.$name;
EOF);

        $process = new Process(['php', $entry, "--target=$target", "--code=$phpCode", "--format=json"]);

        $process->run();

        $result = json_decode($process->getOutput(), true);

        $this->assertEquals('=> "hello tinker"', $result['output']);
    }
}

