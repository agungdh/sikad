<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

use Thamaraiselvam\MysqlImport\Import;
use agungdh\Pustaka;

class ImportDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'importdb {sqlFile} {--R|recreate}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Database with SQL Syntax. Run the .sql file.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment("Preparing ...\n");
        $database = env('DB_DATABASE');
        $user = env('DB_USERNAME');
        $pass = env('DB_PASSWORD');
        $host = env('DB_HOST');

        if ($this->option('recreate')) {
            $this->info("Drop all tables");
            Pustaka::dropTableView($host, $user, $pass, $database);
        }

        $location = base_path($this->argument('sqlFile'));
        $this->info("Importing Database from {$location}");

        new Import($location, $user, $pass, $database, $host);
    }
}
