<?php

namespace App\Http\Livewire\Dashboard;

use Illuminate\View\View;
use Livewire\Component;

class Index extends Component
{
    /**
     * @var string[]
     */
    protected $listeners = [
        'taskWasCreated' => '$refresh',
    ];

    /**
     * @return View
     */
    public function render(): View
    {
        $tasksInPriorityOrder = request()
            ->user()
            ->tasks()
            ->priorityOrder()
            ->where(fn ($query) =>
                $query
                    ->whereHas('source', fn ($sourceQuery) => $sourceQuery->where('active', true))
                    ->orWhereNull('source_id')
            )
            ->get();

        return view('livewire.dashboard.index', [
            'current' => $tasksInPriorityOrder->first(),
            'next' => $tasksInPriorityOrder->slice(1, 1)->first(),
            'backlog' => $tasksInPriorityOrder->slice(2),
        ]);
    }
}
