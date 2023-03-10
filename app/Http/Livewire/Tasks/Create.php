<?php

namespace App\Http\Livewire\Tasks;

use App\Enums\Priorities;
use Illuminate\Validation\Rules\Enum;
use Illuminate\View\View;
use Livewire\Component;

class Create extends Component
{
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
     * @return void
     */
    public function mount(): void
    {
        $this->priority = Priorities::Medium->value;
        $this->due_at = now()->format("Y-m-d");
    }

    /**
     * @return void
     */
    public function create(): void
    {
        $this->validate();

        request()->user()->tasks()->create([
            'title' => $this->title,
            'priority' => $this->priority,
            'due_at' => $this->due_at,
            'description' => $this->description,
        ]);

        $this->reset(['title', 'description']);

        $this->emit("taskWasCreated");

        $this->emitTo('livewire-toast', 'show', 'Task has been created');
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
        return view('livewire.tasks.create');
    }
}
