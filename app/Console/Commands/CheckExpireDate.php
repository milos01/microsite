<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Website;
use Carbon\Carbon;
use Log;

class CheckExpireDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'microsite:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check for webistes expite date in database. If date has expirted sets website to inactive.';

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
        $now = Carbon::now();
        $webistes = Website::all();
        foreach ($webistes as $key => $website) {
            if($website->grace_period && $website->active == 1 && $now->diffInDays($website->grace_period, false) <= 0){
                $website->active = 0;
                $website->save();
            }
        }
    }
}
