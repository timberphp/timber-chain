<?php

namespace Timberphp\TimberChain;

use Timberphp\TimberChain\Drivers\AbstractDriver;
use Timberphp\TimberChain\Drivers\LaravelDriver;
use Timberphp\TimberChain\Drivers\WordpressDriver;
use Timberphp\TimberChain\Drivers\PlanProjectDriver;

class Detector
{
    /**
     * @var string[]
     */
    protected $drivers = [
        LaravelDriver::class,
        WordpressDriver::class,
    ];

    public function detect(string $projectPath)
    {
        foreach ($this->drivers as $driverClass) {
            /** @var AbstractDriver $driver */
            $driver = new $driverClass();

            if ($driver->canBootstrap($projectPath)) {
                return $driver;
            }
        }

        return new PlanProjectDriver();
    }
}
