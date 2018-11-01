<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Reply
 *
 * @property \Carbon\Carbon $created_at
 * @property-read \App\User $owner
 * @mixin \Eloquent
 */
class Reply extends Model
{
    protected $guarded = [];

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
