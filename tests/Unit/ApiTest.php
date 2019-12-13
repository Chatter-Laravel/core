<?php

namespace Chatter\Core\Tests\Unit;

use Chatter\Core\Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ApiTest extends TestCase
{

    public function testDiscussionApi()
    {
        $response = $this->get(route('chatter.api.discussion.index'));
        $response->assertStatus(200)
            ->assertJson([
                'category' => [],
                'links' => [],
                'meta' => [
                    'current_page' => 1
                ]
            ]);

        $page = rand(1, 100);
        $response = $this->get(route('chatter.api.discussion.index', [ 'page' => $page ]));
        $response->assertStatus(200)
            ->assertJson([
                'category' => [],
                'links' => [],
                'meta' => [
                    'current_page' => $page
                ]
            ]);

        $response = $this->get(route('chatter.api.discussion.show', [ 'id' => rand(1, 100) ]));
        $response->assertStatus(404);


        dd($response);
    }
}
