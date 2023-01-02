<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ModalConfirm extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        public string $openEvent,
        public string $closeEvent,
        public string $confirmClick,
        public string $modalTitle = 'Delete Item',
        public string $modalDescription = 'Are you sure you want to delete this item?',
    ){}

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.modal-confirm');
    }
}
