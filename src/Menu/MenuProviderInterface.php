<?php

namespace Chatter\Core\Menu;

interface MenuProviderInterface
{
    public function get(): array;
}
