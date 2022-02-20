<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateDatabase extends Command
{
    protected $signature = 'create:database {--path=}';

    protected $description = 'Creates the sqlite database file.';

    public function handle()
    {
        $db = $this->option('path') ?? config('database.connections.sqlite.database');
        $this->comment(shell_exec(sprintf('touch %s', $db)));
        $this->info(sprintf('Created %s file.', $db));
    }
}
