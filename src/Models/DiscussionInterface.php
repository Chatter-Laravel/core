<?php

namespace Chatter\Core\Models;

interface DiscussionInterface
{
    public function user();
    
    public function category();

    public function posts();

    public function users();

    public function reactions();
    
    public function postsCount();

    public function setBodyAttribute($value);

    public function getBodyAttribute();

    public function getAnsweredAttribute();
    
    public function getAnswersAttribute();

    public function getTimeAgoAttribute();

    public function getLastReplayAttribute();

    public function getUserReactionsAttribute();
    
    public function sluggable();
}
