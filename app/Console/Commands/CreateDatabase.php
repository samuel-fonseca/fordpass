<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateDatabase extends Command
{
    protected $signature = 'create:database';

    protected $description = 'Creates the sqlite database file.';

    public function handle()
    {
        $db = env('DB_DATABASE', base_path('database/database.sqlite'));
        $file = fopen($db, 'w');
        fwrite($file, '');
        fclose($file);

        $this->info(sprintf('Created %s file.', $db));
    }
}
