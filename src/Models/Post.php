<?php

namespace Chatter\Core\Models;

use Auth;
use Chatter\Core\Traits\TimeAgo;
use Chatter\Core\Models\Discussion;
use Chatter\Core\Traits\Reactionable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model implements PostInterface
{
    use SoftDeletes, Reactionable, TimeAgo;

    protected $table = 'chatter_posts';
    protected $fillable = ['body', 'markdown', 'discussion_id'];
    protected $dates = ['deleted_at'];
    protected $touches = ['discussion'];
    
    public $timestamps = true;
    
    public function discussion()
    {
        return $this->belongsTo(Discussion::class, 'discussion_id');
    }

    public function user()
    {
        return $this->belongsTo(config('chatter.user.namespace'));
    }
}
