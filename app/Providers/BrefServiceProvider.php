<?php

namespace App\Providers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class BrefServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        if (! isset($_SERVER['LAMBDA_TASK_ROOT'])) {
            return;
        }

        Config::set('app.env', 'production');
        Config::set('app.debug', false);
        Config::set('database.connections.sqlite.database', '/tmp/database.sqlite');
        Config::set('logging.default', 'stderr');
        Config::set('session.driver', 'array');
        Config::set('cache.default', 'array');
        Config::set('cache.stores.file.path', '/tmp/storage/framework/cache');

        $this->setupDatabase();
    }

    private function setupDatabase(): void
    {
        if (! file_exists(config('database.connections.sqlite.database'))) {
            Artisan::call('create:database', ['--path' => config('database.connections.sqlite.database')]);
            Artisan::call('migrate', ['--force' => true]);
        }
    }
}
