<?php

namespace App\Http\Livewire\Tasks;

use App\Models\Task;
use Illuminate\View\View;
use Livewire\Component;

class Complete extends Component
{
    /**
     * @var Task
     */
    public Task $task;

    /**
     * @var string[]
     */
    protected $listeners = [
        'setCompleteTask',
    ];

    /**
     * @param int $id
     * @return void
     */
    public function setCompleteTask(int $id): void
    {
        $this->task = Task::findOrFail($id);

        if ($this->task->user_id !== request()->user()->id) {
            abort(401);
        }

        $this->emit('completeTask');
    }

    /**
     * @return void
     */
    public function update()
    {
        if ($this->task->user_id !== request()->user()->id) {
            abort(401);
        }

        $this->task->update([
            'completed_at' => now(),
        ]);

        $this->emit("taskWasUpdated");

        $this->emitTo('livewire-toast', 'show', 'Task has been updated');
    }

    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire.tasks.complete');
    }
}
