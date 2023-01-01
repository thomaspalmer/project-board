<?php

namespace App\View\Components;

class PrimaryButton extends Button
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.primary-button');
    }
}
