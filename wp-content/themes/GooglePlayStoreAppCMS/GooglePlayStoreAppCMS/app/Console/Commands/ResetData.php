<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ResetData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset Database to fresh content..';

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

        try {
            
            $this->info('Starting.');
           \DB::unprepared(file_get_contents(base_path('docs/appmarket/sql/1.1/database.sql')));
           \Artisan::call('cache:clear');

        } catch (Exception $e) {
            Log::error('Reset Database Problem. '.print_r($e->getMessage(),true));
        }

    }
}
