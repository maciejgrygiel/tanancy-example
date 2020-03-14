<?php
namespace App;

use Hyn\Tenancy\Traits\UsesSystemConnection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChangelogCategory extends Model
{
    use UsesSystemConnection, SoftDeletes;

    protected $fillable = [
        'name',
        'color'
    ];
}
