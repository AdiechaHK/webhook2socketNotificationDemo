<?php

namespace App\Console\Commands;

use App\Jobs\PriorityVideo;
use Illuminate\Console\Command;

class TestPriorityVideo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'send:priotiry_video';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @return int
     */
    public function handle()
    {
        PriorityVideo::dispatch("aaa", "bbb", "google.com");
        return Command::SUCCESS;
    }
}
