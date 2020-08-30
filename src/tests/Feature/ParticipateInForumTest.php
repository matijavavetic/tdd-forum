<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unauth_user_may_not_add_replies()
    {
        $this->post('/threads/somechannel/1/replies', [])
            ->assertRedirect('/login');
    }

    /** @test */
    public function an_auth_user_may_participate_in_forum_threads()
    {
        $user = create(User::class);
        $this->be($user);

        $thread = create(Thread::class);

        $reply = make(Reply::class);

        $this->post($thread->path().'/replies', $reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);
    }
}
