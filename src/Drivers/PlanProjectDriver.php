<?php

namespace Timberphp\TimberChain\Drivers;

class PlanProjectDriver  extends AbstractDriver
{
    public function deployable(string $project): bool
    {
        return false;
    }

    public function rollOut(string $project): void
    {
        if (file_exists($path = $project.'/vendor/autoload.php')) {
            require $path;
        }
    }
}
