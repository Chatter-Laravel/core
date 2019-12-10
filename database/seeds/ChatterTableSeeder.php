<?php

use Illuminate\Database\Seeder;
use Chatter\Core\Models\CategoryInterface;
use Chatter\Core\Models\DiscussionInterface;

class ChatterTableSeeder extends Seeder
{
    /**
     * Auto generated seed file.
     *
     * @return void
     */
    public function run()
    {
        factory(config('chatter.user.namespace'), 10)->create();
        factory(model(CategoryInterface::class), 10)->create();
        factory(model(DiscussionInterface::class), 100)->create();
    }
}
