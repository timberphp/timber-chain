<?php

namespace Timberphp\TimberChain\Tests;

use PHPUnit\Framework\TestCase;

class ExecuteCommandTest extends TestCase
{
    public function test_it_can_execute_php_code()
    {
        $entry = __DIR__.'/../chain';
        $target = __DIR__.'/fixtures/foo';
        $command = <<<BASH
php $entry execute --target=$target "foo()"
BASH;

        $output = shell_exec($command);

        $this->assertEquals("'bar'", trim($output));
    }

    public function test_it_can_execute_base64_encoded_code()
    {
        $entry = __DIR__.'/../chain';
        $target = __DIR__.'/fixtures/foo';
        $phpCode = base64_encode('foo()');
        $command = <<<BASH
php $entry execute --target=$target "$phpCode" --base64
BASH;

        $output = shell_exec($command);

        $this->assertEquals("'bar'", trim($output));
    }

    public function testCanPassMultipleLinesOfCode()
    {
        $entry = __DIR__.'/../chain';
        $target = __DIR__;
        $phpCode = base64_encode(<<<'EOF'
$name = 'tinker';
$greeting = "hello ".$name;
EOF);

        $output = shell_exec(<<<BASH
php $entry execute --target=$target "$phpCode" --base64
BASH
);

        $this->assertEquals("'hello tinker'", $output);
    }
}

