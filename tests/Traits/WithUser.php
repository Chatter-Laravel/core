<?php

namespace Chatter\Core\Tests\Traits;

use App\User;

trait WithUser
{
    protected $user;

    public function setUpUser(): void
    {
        $this->user = factory(User::class)->create();
    }
}
