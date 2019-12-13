<?php

namespace Chatter\Core\Tests\Traits;

use Illuminate\Foundation\Auth\User;

trait WithUser
{
    protected $user;

    public function setUpUser(): void
    {
        // $this->user = factory(User::class)->create();
    }
}
