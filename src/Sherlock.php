<?php

namespace Timberphp\TimberChain;

use Timberphp\TimberChain\Drivers\AbstractDriver;
use Timberphp\TimberChain\Drivers\LaravelDriver;
use Timberphp\TimberChain\Drivers\WordpressDriver;
use Timberphp\TimberChain\Drivers\PlanProjectDriver;

class Sherlock
{
    /**
     * @var string[]
     */
    protected $drivers = [
        LaravelDriver::class,
        WordpressDriver::class,
    ];

    /**
     * @param  string  $subject
     *
     * @return AbstractDriver
     */
    public function detect(string $subject)
    {
        foreach ($this->drivers as $driverClass) {
            $driver = new $driverClass();

            if ($driver->deployable($subject)) {
                return $driver;
            }
        }

        return new PlanProjectDriver();
    }
}
