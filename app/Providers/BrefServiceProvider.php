<?php

namespace App\Providers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\ServiceProvider;

class BrefServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $isRunningInLambda = isset($_SERVER['LAMBDA_TASK_ROOT']);

        // The rest below is specific to AWS Lambda
        if (! $isRunningInLambda) {
            return;
        }

        Config::set('app.env', 'production');
        Config::set('app.debug', false);
        Config::set('database.connections.sqlite.database', '/tmp/storage/database/database.sqlite');
        Config::set('logging.default', 'stderr');
        Config::set('session.driver', 'array');
        Config::set('cache.stores.file.path', '/tmp/storage/framework/cache');
    }
}
