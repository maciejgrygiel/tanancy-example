<?php
namespace App;

use Hyn\Tenancy\Environment;
use Hyn\Tenancy\Traits\UsesSystemConnection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChangelogEntry extends Model
{
    use UsesSystemConnection, SoftDeletes;

    protected $fillable = [
        'category_id',
        'title',
        'content',
        'published',
        'published_at'
    ];

    public function category()
    {
        return $this->belongsTo('App\ChangelogCategory');
    }

    public function userMark()
    {
        return $this->hasOne('App\ChangelogEntryMark', 'entry_id')->where('website_id', app(Environment::class)->tenant()->id);
    }
}
