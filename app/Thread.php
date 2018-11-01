<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Thread
 *
 * @property-read \App\Channel $channel
 * @property-read \App\User $creator
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Reply[] $replies
 * @mixin \Eloquent
 */
class Thread extends Model
{
    //

    protected $guarded = [];

    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * @param $reply array
     */
    public function addReply($reply)
    {
        $this->replies()->create($reply);
    }
}
