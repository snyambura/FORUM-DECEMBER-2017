<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadsTest extends TestCase
{
    /**
     * @return void
     */
    use RefreshDatabase;
    public function setUp()
    {
        parent::setup();

        $this->thread = factory(Thread::class)->create();
    }


    public function test_a_user_can_browse_threads()
    {

        $response = $this->get('/threads');

        $response->assertSee($this->thread->title);


    }

    public function test_a_user_can_read_a_single_thread()
    {
        $response = $this->get('/threads/' .$this->thread->id);

        $response->assertSee($this->thread->title);
    }

    public function test_a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        $reply = factory(Reply::class)->create(['thread_id' => $this->thread->id]);

        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }
}
