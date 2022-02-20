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
        $this->comment(shell_exec('vendor/bin/bref cli fordpass-production-web  -- create:database'));
        $this->comment(shell_exec('vendor/bin/bref cli fordpass-production-web  -- migrate --force'));
    }
}
