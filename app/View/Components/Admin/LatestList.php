<?php

namespace App\View\Components\Admin;

use Illuminate\View\Component;

class LatestList extends Component
{
    public $title;
    public $items;
    public $route;
    public $empty;

    public function __construct($title, $items, $route, $empty = 'لا توجد عناصر.')
    {
        $this->title = $title;
        $this->items = $items;
        $this->route = $route;
        $this->empty = $empty;
    }

    public function render()
    {
        return view('components.admin.latest-list');
    }
}
