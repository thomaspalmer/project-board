<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Task;
use Illuminate\View\View;
use Livewire\Component;

class NextPriority extends Component
{
    /**
     * @var string[]
     */
    protected $listeners = [
        'taskWasCreated' => '$refresh',
    ];

    /**
     * @var ?Task
     */
    public ?Task $task;

    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire.dashboard.next-priority');
    }
}
