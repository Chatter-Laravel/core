<?php

namespace Chatter\Core\Models;

use Chatter\Core\Models\Discussion;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model implements CategoryInterface
{
    use HasFactory;

    protected $table = 'chatter_categories';
    public $timestamps = true;
    public $with = 'parents';

    public function discussions()
    {
        return $this->hasMany(Discussion::class, 'category_id');
    }

    public function parents()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('order', 'asc');
    }
}
