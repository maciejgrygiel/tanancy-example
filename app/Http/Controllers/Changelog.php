<?php

namespace App\Http\Controllers;

use App\ChangelogEntry;
use App\ChangelogEntryMark;
use Carbon\Carbon;
use Hyn\Tenancy\Environment;

class Changelog extends Controller
{
    public function index()
    {
        $entries = ChangelogEntry::query()
            ->where('published', 1)
            ->whereDate('published_at', '<=', Carbon::now())
            ->orderBy('published_at', 'DESC')
            ->get();
        $website = app(Environment::class)->tenant();

        return view('changelog.index', ['entries' => $entries, 'website' => $website]);
    }

    public function markAsRead(int $id)
    {
        $website = app(Environment::class)->tenant();

        ChangelogEntryMark::query()->where('entry_id', $id)->where('website_id', $website->id)->firstOrCreate([
            'entry_id' => $id,
            'website_id' => $website->id
        ]);

        return redirect()->route('changelog.index');
    }
}
