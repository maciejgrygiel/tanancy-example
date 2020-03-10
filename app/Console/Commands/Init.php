<?php

namespace App\Console\Commands;

use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Repositories\WebsiteRepository;
use Illuminate\Console\Command;

class Init extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'init:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create 10 new tenants';

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
        $website = new Website();
        app(WebsiteRepository::class)->create($website);
        $this->line($website->uuid);
    }
}
