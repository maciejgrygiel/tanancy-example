<?php

namespace App\Http\Controllers;

use App\Document;
use Illuminate\Http\Request;

class Changelog extends Controller
{
    public function index()
    {
        $website = app(\Hyn\Tenancy\Environment::class)->tenant();

        dd(Document::all()->first()->number);

        dd($website->id);
        die();
    }
}
