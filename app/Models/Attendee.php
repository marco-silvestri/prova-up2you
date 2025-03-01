<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Attendee extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;

    public function events():BelongsToMany
    {
        return $this->belongsToMany(Event::class);
    }
}
