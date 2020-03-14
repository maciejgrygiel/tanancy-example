<?php

namespace App\Console\Commands;

use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;
use Hyn\Tenancy\Models\Hostname;
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
    protected $signature = 'example:run';

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
        for ($i = 0; $i < 1; $i++) {
            $website = new Website();
            app(WebsiteRepository::class)->create($website);

            $hostname = new Hostname();
            $hostname->fqdn = sprintf('t%d.tenancy.local', $website->id);
            $hostname = app(HostnameRepository::class)->create($hostname);
            app(HostnameRepository::class)->attach($hostname, $website);
            $this->line($website->uuid);
        }
    }
}
