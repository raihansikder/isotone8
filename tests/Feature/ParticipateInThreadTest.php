<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInThreadTest extends TestCase
{

    use DatabaseMigrations; // This will migrate all database and finally undo/rollback all migrations   // This will migrate all database and finally undo/rollback all migrations

    /** @test */
    public function unauthenticated_user_may_not_add_replies()
    {

        // and an existing thread
        $thread = create(Thread::class);

        // OK if this AuthenticationException occurs when attempted to post
        // Equivalent to : $this->expectException(AuthenticationException::class);
        $this->withExceptionHandling()
            ->post(route('replies.store', [$thread->channel->slug, $thread->id]), [])
            ->assertRedirect(route('login')); // After post redirect to login
    }

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        // Given we have a authenticated user
        $this->be($user = factory(User::class)->create());

        // and an existing thread
        $thread = create(Thread::class);

        // When the user adds a reply to the thread
        $reply = make(Reply::class);

        // Then their reply should be visible to the page
        // dd(route('threads.show', [$thread->channel->slug, $thread->id]));
        $this->post(route('replies.store', [$thread->channel->slug, $thread->id]), $reply->toArray());

        $this->get(route('threads.show', [$thread->channel->slug, $thread->id]))
            ->assertSee($reply->body);

    }

    /** @test */
    function a_reply_requires_a_body()
    {
        $this->withExceptionHandling()->signIn();

        // and an existing thread
        $thread = create(Thread::class);

        // When the user adds a reply to the thread
        $reply = make(Reply::class, ['body' => null]);

        $this->post(route('replies.store', [$thread->channel->slug, $thread->id]), $reply->toArray())
            ->assertSessionHasErrors('body');

    }
}
