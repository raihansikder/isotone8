<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Channel
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Thread[] $threads
 * @mixin \Eloquent
 */
class Channel extends Model
{
    //

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function threads()
    {
        return $this->hasMany(Thread::class);
    }
}
