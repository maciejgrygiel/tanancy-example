<?php

namespace Tests\Feature;

use App\ChangelogEntry;
use App\ChangelogEntryMark;
use Hyn\Tenancy\Contracts\Repositories\HostnameRepository;
use Hyn\Tenancy\Models\Hostname;
use Hyn\Tenancy\Models\Website;
use Hyn\Tenancy\Repositories\WebsiteRepository;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class ChangelogTest extends TestCase
{

    /**
     * @var Website $website
     */
    protected $website;

    /**
     * @var Hostname $hostname
     */
    protected $hostname;

    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('migrate:fresh', ['--env' => 'testing']);
        Artisan::call('db:seed', ['--env' => 'testing']);

        $this->website = new Website();
        app(WebsiteRepository::class)->create($this->website);

        $this->hostname = new Hostname();
        $this->hostname->fqdn = 'test.tenancy.local';
        $this->hostname = app(HostnameRepository::class)->create($this->hostname);
        app(HostnameRepository::class)->attach($this->hostname, $this->website);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testMarkAsRead()
    {
        $response = $this->get('http:// ' . $this->hostname->fqdn . '/');

        $response->assertStatus(200);

        $lastChangelogEntry = ChangelogEntry::query()->latest('published_at')->first();

        $response = $this->get('http:// ' . $this->hostname->fqdn . '/mark/' . $lastChangelogEntry->id);
        $response->assertRedirect();

        $mark = ChangelogEntryMark::query()->where('website_id', $this->website->id)->where('entry_id', $lastChangelogEntry->id)->first();

        $this->assertNotNull($mark);
    }

    public function tearDown(): void
    {
        app(HostnameRepository::class)->delete($this->hostname);
        app(WebsiteRepository::class)->delete($this->website, true);

        parent::tearDown();
    }
}
