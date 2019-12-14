<?php

namespace Chatter\Core\Models;

interface PostInterface
{
    public function discussion();

    public function user();

    public function reactions();

    public function getTimeAgoAttribute();

    public function getUserReactionsAttribute();
}
