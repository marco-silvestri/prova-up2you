<?php

namespace App\Models;

use App\Models\Attendee;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Event extends Model
{
    protected $guarded = ['id'];
    public $timestamps = false;

    public function attendees():BelongsToMany
    {
        return $this->belongsToMany(Attendee::class);
    }
}
