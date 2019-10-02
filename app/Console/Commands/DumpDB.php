<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Ifsnop\Mysqldump as IMysqldump;

class DumpDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dumpdb';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dump the Database';

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
     
        $this->info(
            "Host\t\t: " . $host . "\n" . 
            "Database\t: " . $database . "\n" . 
            "Username\t: " . $user . "\n" . 
            "Password\t: " . $pass . "\n"
        );

        $path = base_path('db.sql');
        $this->comment("Set dumping path to " . $path . "\n");
        
        $this->comment("Dumping the database\n");
        try {
            $dump = new IMysqldump\Mysqldump("mysql:host={$host};dbname={$database}", "{$user}", "{$pass}");

            $dump->start($path);

            $this->info("Done ...");
        } catch (\Exception $e) {
            $this->comment("An error occurred !!!");
            $this->error($e->getMessage());
        }
    }
}
