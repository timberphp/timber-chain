<?php

namespace Timberphp\TimberChain\Drivers;

abstract class AbstractDriver
{
    abstract function deployable(string $project): bool;

    /**
     * Autobots roll out!
     *
     * @param  string  $project
     */
    abstract function rollOut(string $project): void;

    public function casters(): array
    {
        return [];
    }
}