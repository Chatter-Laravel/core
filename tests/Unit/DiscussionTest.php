<?php

namespace Chatter\Core\Tests\Unit;

use Chatter\Core\Tests\CreatesApplication;
use Chatter\Core\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DiscussionTest extends TestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    public function test()
    {
        $response = $this->get(route('chatter.discussion'));

        $response->assertStatus(404);
    }
}
