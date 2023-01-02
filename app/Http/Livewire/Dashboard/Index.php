<?php

namespace App\Http\Livewire\Dashboard;

use App\Enums\Priorities;
use Illuminate\View\View;
use Livewire\Component;

class Index extends Component
{
    /**
     * @return View
     */
    public function render(): View
    {
        $tasksInPriorityOrder = request()->user()->tasks()->priorityOrder()->get();

        return view('livewire.dashboard.index', [
            'current' => $tasksInPriorityOrder->first(),
            'next' => $tasksInPriorityOrder->slice(1, 1)->first(),
            'backlog' => $tasksInPriorityOrder->slice(2),
        ]);
    }
}
