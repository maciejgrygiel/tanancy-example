<?php

namespace App\Http\Controllers;

use App\ChangelogEntry;
use App\Document;
use Illuminate\Http\Request;

class Changelog extends Controller
{
    public function index()
    {
        $entries = ChangelogEntry::query()->orderBy('published_at', 'DESC')->where('published', 1)->get();
        $website = app(\Hyn\Tenancy\Environment::class)->tenant();

        return view('changelog.index', ['entries' => $entries, 'website' => $website]);
    }
}
