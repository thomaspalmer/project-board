<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Task;
use Illuminate\View\View;
use Livewire\Component;

class CurrentPriority extends Component
{
    /**
     * @var Task
     */
    public Task $task;

    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire.dashboard.current-priority');
    }
}
