<?php

namespace Timberphp\TimberChain\Drivers;

class PlanProjectDriver  extends AbstractDriver
{
    public function canBootstrap(string $project): bool
    {
        return false;
    }

    public function bootstrap(string $projectPath): void
    {
        if (file_exists($path = $projectPath.'/vendor/autoload.php')) {
            require $path;
        }
    }
}
