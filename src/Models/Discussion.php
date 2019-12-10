<?php

namespace Chatter\Core\Models;

use Str;
use Mews\Purifier\Purifier;
use Chatter\Core\Models\PostInterface;
use Illuminate\Database\Eloquent\Model;
use Chatter\Core\Models\CategoryInterface;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discussion extends Model implements DiscussionInterface
{
    use SoftDeletes, Sluggable;

    public $timestamps = true;
    
    protected $table = 'chatter_discussion';
    protected $fillable = ['title', 'category_id', 'color'];
    protected $dates = ['deleted_at', 'last_reply_at'];

    public function user()
    {
        return $this->belongsTo(config('chatter.user.namespace'));
    }

    public function category()
    {
        return $this->belongsTo(model(CategoryInterface::class), 'category_id');
    }

    public function posts()
    {
        return $this->hasMany(model(PostInterface::class), 'discussion_id')->orderBy('created_at', 'asc');
    }

    public function users()
    {
        return $this->belongsToMany(config('chatter.user.namespace'), 'chatter_user_discussion', 'discussion_id', 'user_id');
    }

    public function postsCount()
    {
        $count = $this->posts()->count();

        return $count > 0 ? $count - 1 : 0;
    }

    public function setBodyAttribute($value)
    {
        $this->attributes['body'] = Purifier::clean($value);
    }

    public function getBodyAttribute()
    {
        $post = $this->posts()->orderBy('created_at', 'asc')->first();
        
        if (null !== $post) {
            return Str::words(str_replace(array("\t", "\r", "\n"), '', strip_tags($post->body)), 30);
        }
    }

    public function getAnsweredAttribute()
    {
        return $this->postsCount() > 1;
    }
    
    public function getAnswersAttribute()
    {
        return $this->postsCount();
    }

    public function getTimeAgoAttribute()
    {
        return $this->created_at->diffForHumans();
    }

    public function getLastReplayAttribute()
    {
        return $this->posts()->orderBy('created_at', 'desc')->first();
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
