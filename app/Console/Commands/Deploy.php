<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Deploy extends Command
{
    protected $signature = 'deploy';

    protected $description = 'Deploy the application using serverless.';

    public function handle()
    {
        $this->comment(shell_exec('composer install --prefer-dist --optimize-autoloader --no-dev'));
        $this->comment(shell_exec('serverless deploy'));
    }
}
