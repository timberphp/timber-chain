<?php

namespace Timberphp\TimberChain\Drivers;

class WordpressDriver extends AbstractDriver
{
    public function deployable(string $project): bool
    {
        return file_exists($project.'/wp-load.php');
    }

    public function rollOut(string $project): void
    {
        require $project.'/wp-load.php';
    }
}
