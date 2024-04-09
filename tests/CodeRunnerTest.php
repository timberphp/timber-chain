<?php

namespace Timberphp\TimberChain\Tests;

use Timberphp\TimberChain\CodeRunner;
use \PHPUnit\Framework\TestCase;

class CodeRunnerTest extends TestCase
{
    protected CodeRunner $codeRunner;

    public function setUp(): void
    {
        parent::setUp();

        $this->codeRunner = new CodeRunner();
    }

    public function testItLoadDefaultVendor()
    {
        $target = __DIR__.'/fixtures/foo';
        $phpCode = 'foo()';

        $output = $this->codeRunner->bootstrapAt($target)->execute($phpCode);

        $this->assertStringContainsString('bar', $output);
    }
}

