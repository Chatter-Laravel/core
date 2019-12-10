<?php

namespace Chatter\Core\Menu;

class MenuProvider implements MenuProviderInterface
{
    public function get(): array
    {
        return [
            new MenuItem(__('app.menu.home'), route('chatter.home', [], false)),
            // new MenuItem(__('app.menu.category'), 'category'),
            new MenuItem(__('app.menu.test'), 'test')
        ];
    }
}
