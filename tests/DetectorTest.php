<?php

namespace  Timberphp\TimberChain\Tests;

use Timberphp\TimberChain\Drivers\LaravelDriver;
use Timberphp\TimberChain\Drivers\PlanProjectDriver;
use Timberphp\TimberChain\Detector;
use PHPUnit\Framework\TestCase;

class DetectorTest extends TestCase
{
    protected Detector $sherlock;

    public function setUp(): void
    {
        parent::setUp();

        $this->sherlock = new Detector();
    }

    public function testItCanDetectLaravelDriver()
    {
        $subject = $this->sherlock->detect(__DIR__.'/fixtures/drivers/laravel');

        $this->assertInstanceOf(LaravelDriver::class, $subject);
    }

    public function testItCanFallbackToPlanDriverIfCanNotDetectAnyThing()
    {
        $subject = $this->sherlock->detect(__DIR__.'/fixtures/drivers/dummy');

        $this->assertInstanceOf(PlanProjectDriver::class, $subject);
    }
}

