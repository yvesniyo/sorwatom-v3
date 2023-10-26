<?php

namespace App\Console\Commands;

use App\Models\UserCategory;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        DB::transaction(function () {
            
            //TODO:: user categories create
            UserCategory::insert([
                [
                    "id" => 1,
                    "name" => "Marchandise",
                ]
            ]);
        });
    }
}
