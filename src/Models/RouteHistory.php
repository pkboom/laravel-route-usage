<?php

namespace Pkboom\RouteUsageCounter\Models;

use Illuminate\Database\Eloquent\Model;

class RouteHistory extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected $table = 'route_history';

    protected $casts = [
        'created_at' => 'datetime',
    ];
}
