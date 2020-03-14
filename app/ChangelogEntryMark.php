<?php
namespace App;

use Hyn\Tenancy\Traits\UsesSystemConnection;
use Illuminate\Database\Eloquent\Model;

class ChangelogEntryMark extends Model
{
    use UsesSystemConnection;

    protected $fillable = [
        'entry_id',
        'website_id'
    ];
}
