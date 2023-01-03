<?php

namespace App\Http\Livewire\Tasks;

use App\Enums\Priorities;
use App\Models\Task;
use Illuminate\Validation\Rules\Enum;
use Illuminate\View\View;
use Livewire\Component;

class Edit extends Component
{
    /**
     * @var Task
     */
    public Task $task;

    /**
     * @var string
     */
    public string $title = '';

    /**
     * @var string
     */
    public string $priority = '';

    /**
     * @var string
     */
    public string $due_at = '';

    /**
     * @var string
     */
    public string $description = '';

    /**
     * @var string[]
     */
    protected $listeners = [
        'setEditTask',
    ];

    /**
     * @param int $id
     * @return void
     */
    public function setEditTask(int $id): void
    {
        $this->task = Task::findOrFail($id);

        if ($this->task->user_id !== request()->user()->id) {
            abort(401);
        }

        $this->title = $this->task->title;
        $this->priority = $this->task->priority->value;
        $this->due_at = $this->task->due_at->format("Y-m-d");
        $this->description = $this->task->description;

        $this->emit('editTask');
    }

    /**
     * @return void
     */
    public function update()
    {
        if ($this->task->user_id !== request()->user()->id) {
            abort(401);
        }

        $this->validate();

        $this->task->update([
            'title' => $this->title,
            'priority' => $this->priority,
            'due_at' => $this->due_at,
            'description' => $this->description,
        ]);

        $this->emit("taskWasUpdated");

        $this->emitTo('livewire-toast', 'show', 'Task has been updated');
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'title' => [
                'required',
                'string',
                'max:255',
            ],
            'priority' => [
                'required',
                new Enum(Priorities::class),
            ],
            'due_at' => [
                'required',
                'date',
            ],
            'description' => [
                'nullable',
                'string',
                'max:500000',
            ],
        ];
    }

    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire.tasks.edit');
    }
}
