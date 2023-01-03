<?php

namespace App\Http\Livewire\Tasks;

use App\Models\Task;
use Illuminate\View\View;
use Livewire\Component;

class Delete extends Component
{
    /**
     * @var Task
     */
    public Task $task;

    /**
     * @var string[]
     */
    protected $listeners = [
        'setDeleteTask',
    ];

    /**
     * @param int $id
     * @return void
     */
    public function setDeleteTask(int $id): void
    {
        $this->task = Task::findOrFail($id);

        if ($this->task->user_id !== request()->user()->id) {
            abort(401);
        }

        $this->emit('deleteTask');
    }

    /**
     * @return void
     */
    public function delete()
    {
        if ($this->task->user_id !== request()->user()->id) {
            abort(401);
        }

        $this->task->delete();

        $this->emit("taskWasDeleted");

        $this->emitTo('livewire-toast', 'show', 'Task has been deleted');
    }

    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire.tasks.delete');
    }
}
