<?php

namespace Chatter\Core\Models;

use Str;
use Auth;
use Chatter\Core\Models\Post;
use Chatter\Core\Traits\TimeAgo;
use Chatter\Core\Models\Category;
use Chatter\Core\Traits\Reactionable;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discussion extends Model implements DiscussionInterface
{
    use SoftDeletes, Sluggable, Reactionable, TimeAgo;

    public $timestamps = true;
    
    protected $table = 'chatter_discussions';
    protected $fillable = ['title', 'category_id', 'color', 'last_reply_at'];
    protected $dates = ['deleted_at', 'last_reply_at'];

    public function user()
    {
        return $this->belongsTo(config('chatter.user.namespace'));
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'discussion_id');
    }

    public function users()
    {
        return $this->belongsToMany(config('chatter.user.namespace'), 'chatter_user_discussion', 'discussion_id', 'user_id');
    }

    /**
     * Returns the post counts without the
     * first one because is the discussion
     * itself.
     *
     * @return int
     */
    public function postsCount()
    {
        $count = $this->posts()->count();

        return $count > 0 ? $count - 1 : 0;
    }

    /**
     * Sets the body attribute
     *
     * @param string $value
     * @return void
     */
    public function setBodyAttribute($value)
    {
        $this->attributes['body'] = resolve('purifier')->clean($value);
    }

    /**
     * Returs the body attribute
     *
     * @return string
     */
    public function getBodyAttribute()
    {
        $post = $this->posts()->oldest()->first();
        
        if (null !== $post) {
            return Str::words(str_replace(array("\t", "\r", "\n"), '', strip_tags($post->body)), 30);
        }
    }

    /**
     * Returns true if the discussion was answered
     *
     * @return bool
     */
    public function getAnsweredAttribute()
    {
        return $this->postsCount() > 0;
    }
    
    /**
     * Returns the number of answers the discussion got
     *
     * @return int
     */
    public function getAnswersAttribute()
    {
        return $this->postsCount();
    }

    /**
     * Returns the last reply of the discussion
     *
     * @return PostInterface|null
     */
    public function getLastReplayAttribute()
    {
        if ($this->answered) {
            return $this->posts()->latest()->first();
        }
        
        return null;
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
