<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Button extends Component
{

    public $type;

    public $className;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($type, $className)
    {
        $this->type = $type;
        $this->className = $className;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.button');
    }
}
