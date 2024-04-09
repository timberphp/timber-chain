<?php

namespace Timberphp\TimberChain\Drivers;

class LaravelDriver extends AbstractDriver
{
    public function canBootstrap(string $project): bool
    {
        return file_exists($project.'/artisan') && file_exists($project.'/public/index.php');
    }

    public function bootstrap(string $projectPath): void
    {
        require_once $projectPath.'/vendor/autoload.php';

        $app = require $projectPath.'/bootstrap/app.php';

        $kernel = $app->make('Illuminate\Contracts\Console\Kernel');

        $kernel->bootstrap();
    }

    public function casters(): array
    {
        return [
            'Illuminate\Support\Collection' => 'Laravel\Tinker\TinkerCaster::castCollection',
            'Illuminate\Database\Eloquent\Model' => 'Laravel\Tinker\TinkerCaster::castModel',
            'Illuminate\Foundation\Application' => 'Laravel\Tinker\TinkerCaster::castApplication'
        ];
    }
}
