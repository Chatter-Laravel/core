<?php

namespace Chatter\Core\Models;

use Illuminate\Database\Eloquent\Model;
use Chatter\Core\Models\DiscussionInterface;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model implements PostInterface
{
    use SoftDeletes;

    protected $table = 'chatter_post';
    public $timestamps = true;
    protected $fillable = ['body', 'markdown', 'discussion_id'];
    protected $dates = ['deleted_at'];

    public function discussion()
    {
        return $this->belongsTo(model(DiscussionInterface::class), 'discussion_id');
    }

    public function user()
    {
        return $this->belongsTo(config('chatter.user.namespace'));
    }

    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }
}
