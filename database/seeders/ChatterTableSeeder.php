<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
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
        User::factory()->count(10)->create();
        Category::factory()->count(10)->create();
        Discussion::factory()->count(100)->create();
    }
}
