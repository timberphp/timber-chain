<?php

namespace Timberphp\TimberChain\Drivers;

class WordpressDriver extends AbstractDriver
{
    public function canBootstrap(string $project): bool
    {
        return file_exists($project.'/wp-load.php');
    }

    public function bootstrap(string $projectPath): void
    {
        require $projectPath.'/wp-load.php';
    }
}
