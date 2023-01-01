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
        $priorityOrder = '\'' . collect(Priorities::cases())
                ->map(fn ($priority) => $priority->value)
                ->join('\', \'') . '\'';

        $tasksInPriorityOrder = request()
            ->user()
            ->tasks()
            ->whereNull('completed_at')
            ->orderByRaw('FIELD(priority, ' . $priorityOrder . ')')
            ->orderBy('due_at', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('livewire.dashboard.index', [
            'current' => $tasksInPriorityOrder->first(),
            'next' => $tasksInPriorityOrder->slice(1, 1)->first(),
            'backlog' => $tasksInPriorityOrder->slice(2),
        ]);
    }
}
