<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SidebarItem extends Component
{
    public string $href;
    public string $icon;
    public string $title;
    public array $submenu;

    /**
     * Create a new component instance.
     */
    public function __construct($href, $icon, $title, $submenu)
    {
        $this->href = $href;
        $this->icon = $icon;
        $this->title = $title;
        $this->submenu = $submenu;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.sidebar-item');
    }
}
