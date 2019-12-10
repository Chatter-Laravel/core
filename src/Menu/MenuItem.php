<?php

namespace Chatter\Core\Menu;

class MenuItem implements MenuItemInterface
{
    public $name;
    public $url;

    public function __construct(string $name, string $url)
    {
        $this->name = $name;
        $this->url = $url;
    }
}
