<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SidebarTab extends Component
{
    public function __construct(public string $href ='#', public string $icon, public string $name){}

    public function render(): View|Closure|string
    {
        return view('components.sidebar-tab');
    }
}
