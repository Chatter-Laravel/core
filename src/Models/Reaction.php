<?php

namespace Chatter\Core\Models;

use Str;
use Auth;
use Illuminate\Database\Eloquent\Model;

class Reaction extends Model implements ReactionInterface
{
    protected $table = 'chatter_reactions';

    protected $fillable = ['user_id', 'emoji', 'emoji_name'];

    public $timestamps = true;

    public function reactionable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(config('chatter.user.namespace'));
    }

    public function getEmojiCountAttribute(): int
    {
        return $this->query()
            ->where('emoji_name', $this->emoji_name)
            ->where('reactionable_id', $this->reactionable_id)
            ->count();
    }

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
