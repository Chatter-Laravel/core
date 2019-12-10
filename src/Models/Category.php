<?php

namespace Chatter\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Chatter\Core\Models\DiscussionInterface;

class Category extends Model implements CategoryInterface
{
    protected $table = 'chatter_categories';
    public $timestamps = true;
    public $with = 'parents';

    public function discussions()
    {
        return $this->hasMany(model(DiscussionInterface::class), 'category_id');
    }

    public function parents()
    {
        return $this->hasMany(model(self::class), 'parent_id')->orderBy('order', 'asc');
    }
}
