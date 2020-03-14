<?php
namespace App;

use Hyn\Tenancy\Traits\UsesSystemConnection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChangelogEntry extends Model
{
    use UsesSystemConnection, SoftDeletes;

    public function category()
    {
        return $this->belongsTo('App\ChangelogCategory');
    }
}
