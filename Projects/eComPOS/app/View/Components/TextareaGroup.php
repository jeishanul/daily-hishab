<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TextareaGroup extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $name,
        public $title,
        public $placeholder,
        public $value = null,
        public $required = true
    ) {
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.textarea-group');
    }
}