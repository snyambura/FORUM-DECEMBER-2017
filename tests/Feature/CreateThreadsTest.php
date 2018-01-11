<?php

namespace Tests\Feature;

use App\Channel;
use App\Thread;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateThreadsTest extends TestCase
{

    use RefreshDatabase;


    function test_guests_may_not_create_threads()
    {
//        $this->withExceptionHandling();
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->get('/threads/create')->assertRedirect('/login');

        $this->post('/threads', [])->assertRedirect('/login');
    }

    function test_an_authenticated_user_can_create_new_forum_threads()
    {

        $this->signIn();

        $thread = make(Thread::class);

        $response = $this->post('/threads', $thread->toArray());

        $thread->get($response->headers->get('Location'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    function test_a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])->assertSessionHasErrors('title');

    }

    function test_a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])->assertSessionHasErrors('body');

    }

    function test_a_thread_requires_a_valid_channel()
    {
        factory(Channel::class, 2)->create();

        $this->publishThread(['channel_id' => null])->assertSessionHasErrors('channel_id');

        $this->publishThread(['channel_id' => 999])->assertSessionHasErrors('channel_id');

    }

    public function publishThread($overrides = [])
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->signIn();

        $thread = make(Thread::class, $overrides);

        return $this->post('/threads', $thread->toArray());
    }
}
