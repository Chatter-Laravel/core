<?php

namespace Chatter\Core\Models;

use Illuminate\Database\Eloquent\Model;

interface CategoryInterface
{
    public function discussions();

    public function parents();
}
