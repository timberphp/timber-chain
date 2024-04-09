<?php

namespace Timberphp\TimberChain\Drivers;

abstract class AbstractDriver
{
    abstract function canBootstrap(string $project): bool;

    /**
     * Autobots roll out!
     *
     * @param  string  $projectPath
     */
    abstract function bootstrap(string $projectPath): void;

    public function casters(): array
    {
        return [];
    }
}