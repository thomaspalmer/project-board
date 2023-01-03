<?php

namespace App\Http\Livewire\Tasks;

use App\Models\Task;
use Illuminate\View\View;
use Livewire\Component;

class DropdownOptions extends Component
{
    /**
     * @var Task
     */
    public Task $task;

    /**
     * @param Task $task
     * @return void
     */
    public function mount(Task $task): void
    {
        $this->task = $task;
    }

    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire.tasks.dropdown-options');
    }
}
