<?php

use Illuminate\Database\Seeder;
use Chatter\Core\Models\Category;
use Chatter\Core\Models\Discussion;

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
        factory(Category::class, 10)->create();
        factory(Discussion::class, 100)->create();
    }
}
