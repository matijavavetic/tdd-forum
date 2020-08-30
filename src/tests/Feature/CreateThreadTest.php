<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CreateThreadTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function guest_may_not_create_threads()
    {
        $this->expectException(AuthenticationException::class);
        $this->withoutExceptionHandling();

        $thread = make(Thread::class);

        $this->post('/threads', $thread->toArray());
    }

    /** @test */
    public function an_auth_user_can_create_new_forum_threads()
    {
        $this->signIn();

        $thread = make(Thread::class);

        $this->post('/threads', $thread->toArray());

        $this->get($thread->path())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}