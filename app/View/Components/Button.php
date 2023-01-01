<?php

namespace App\View\Components;

use Illuminate\View\Component;

abstract class Button extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $type = "button",
        public ?string $href = null,
        public ?string $click = null,
    ) {}
}
