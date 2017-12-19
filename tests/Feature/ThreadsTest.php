<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ThreadsTest extends TestCase
{
    /**
     * @return void
     */
    use RefreshDatabase;

    public function test_a_user_can_browse_threads()
    {
        $thread = factory('App\Thread')->create();

        $response = $this->get('/threads');

        $response->assertSee($thread->title);


    }

    public function test_a_user_can_read_a_single_thread()
    {
        $thread = factory('App\Thread')->create();
        $response = $this->get('/threads/' .$thread->id);
        $response->assertSee($thread->title);
    }
}
