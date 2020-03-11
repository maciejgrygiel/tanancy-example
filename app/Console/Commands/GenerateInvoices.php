<?php

namespace App\Console\Commands;

use App\Document;
use App\Jobs\GenerateInvoicesRun;
use Hyn\Tenancy\Environment;
use Hyn\Tenancy\Repositories\WebsiteRepository;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GenerateInvoices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generateInvoices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display invoices from given tenants';

    /**
     * Custom options from command line.
     * @var array
     */
    protected $customOptions = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->ignoreValidationErrors();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->parseInputForCustomOptions((string) $this->input);

        GenerateInvoicesRun::dispatch($this->customOptions);

        $environment = app(Environment::class);


        $websites = DB::table('websites');

        if ($this->hasCustomOption('tenant')) {
            $websites->whereIn('id', explode(',', $this->customOption('tenant')));
        }

        $websites = $websites->get();

        foreach ($websites as $website) {
            $tenant = app(WebsiteRepository::class)->findByUuid($website->uuid);
            $environment->tenant($tenant);

            $documents = Document::query();

            $this->applyFiltersToQuery($documents);

            $this->line(sprintf('Tenant %d', $website->id));
            $this->table(['id', 'division_id', 'recipient_user_id', 'issuer_user_id', 'number'], $documents->get()->toArray());
        }

        if ($this->hasCustomOption('test')) {
            $this->displayOptions();
        }
    }

    /**
     * Displays options from command line.
     */
    protected function displayOptions() : void
    {
        $this->line('Passed parameters:');
        $this->table(['key', 'value'], array_map(function($key, $value) {
            return [$key, $value];
        }, array_keys($this->customOptions), $this->customOptions));
    }

    /**
     * Applies conditions to query based on command options.
     *
     * @param Builder $documents
     */
    protected function applyFiltersToQuery(Builder $documents) : void
    {
        if ($this->hasCustomOption('division_id')) {
            $documents->where('division_id', $this->customOption('division_id'));
        }

        if ($this->hasCustomOption('recipient_user_id')) {
            $documents->where('recipient_user_id', $this->customOption('recipient_user_id'));
        }

        if ($this->hasCustomOption('issuer_user_id')) {
            $documents->where('issuer_user_id', $this->customOption('issuer_user_id'));
        }

        if ($this->hasCustomOption('number')) {
            $documents->where('number', $this->customOption('number'));
        }
    }

    /**
     * Process command input into custom options.
     *
     * @param string $input
     */
    protected function parseInputForCustomOptions(string $input): void
    {
        array_map(function($item) {
            if (!Str::startsWith($item, '--')) {
                return;
            }

            if (!Str::contains($item, '=')) {
                $this->customOptions[Str::replaceFirst('--', '', $item)] = true;
            } else {
                list($option, $value) = explode('=', $item);

                $this->customOptions[Str::replaceFirst('--', '', $option)] = trim($value, '"');
            }
        }, explode(' ', $input));
    }

    /**
     * @param string $key
     * @return bool
     */
    protected function hasCustomOption(string $key) : bool
    {
        return array_key_exists($key, $this->customOptions);
    }

    /**
     * @param $key
     * @return mixed|null
     */
    protected function customOption($key)
    {
        return $this->hasCustomOption($key) ? $this->customOptions[$key] : null;
    }
}
