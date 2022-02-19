<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Deploy extends Command
{
    protected $signature = 'deploy';

    protected $description = 'Deploy the application using serverless.';

    public function handle()
    {
        `composer install --prefer-dist --optimize-autoloader --no-dev`;
        `serverless deploy`;
    }
}
