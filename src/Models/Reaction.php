<?php

namespace Chatter\Core\Models;

use Str;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model implements ReactionInterface
{
    public $timestamps = true;

    protected $table = 'chatter_reactions';
    protected $fillable = ['user_id', 'emoji', 'emoji_name'];
    protected $touches = ['reactionable'];

    public function reactionable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(config('chatter.user.namespace'));
    }

    /**
     * Gets the total reactions for that emoji
     * for that model
     *
     * @return integer
     */
    public function getEmojiCountAttribute(): int
    {
        return $this->query()
            ->where('emoji_name', $this->emoji_name)
            ->where('reactionable_id', $this->reactionable_id)
            ->count();
    }

    /**
     * Sets the user_recated attribute. Returns
     * true if the user had reacted to the related
     * model (post/discussion)
     *
     * @return void
     */
    public function getUserReactedAttribute()
    {
        if (Auth::check()) {
            return $this->query()
                ->where('emoji_name', $this->emoji_name)
                ->where('reactionable_id', $this->reactionable_id)
                ->where('user_id', Auth::user()->id)
                ->exists();
        }
        
        return null;
    }
}
