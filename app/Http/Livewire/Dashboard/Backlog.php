<?php

namespace App\Http\Livewire\Dashboard;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use Livewire\Component;

class Backlog extends Component
{
    /**
     * @var string[]
     */
    protected $listeners = [
        'taskWasCreated' => '$refresh',
    ];

    /**
     * @var ?Collection
     */
    public ?Collection $tasks;

    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire.dashboard.backlog');
    }
}
