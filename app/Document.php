<?php
namespace App;

use Hyn\Tenancy\Traits\UsesTenantConnection;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    use UsesTenantConnection;
}
