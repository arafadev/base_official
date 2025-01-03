<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ActionLink extends Component
{
    public $href;
    public $class;
    public $dataId;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($href, $class = '', $dataId = null)
    {
        $this->href = $href;
        $this->class = $class;
        $this->dataId = $dataId;
    }

    /**
     * Get the icon class based on the action class.
     *
     * @return string
     */
    public function getIcon()
    {
        $icons = [
            'show' => 'fe fe-eye',
            'edit' => 'fe fe-edit',
            'delete' => 'fe fe-trash',
        ];

        return $icons[$this->class] ?? 'fe fe-default'; 
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|string
     */
    public function render()
    {
        return view('components.action-link');
    }
}
