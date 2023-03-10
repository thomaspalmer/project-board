<?php

namespace App\Http\Livewire\Sources;

use App\Models\Source;
use Illuminate\View\View;
use Livewire\Component;

class Delete extends Component
{
    /**
     * @var Source
     */
    public Source $source;

    /**
     * @var string[]
     */
    protected $listeners = [
        'setDeleteSource'
    ];

    /**
     * @param int $id
     * @return void
     */
    public function setDeleteSource(int $id): void
    {
        $this->source = Source::findOrFail($id);

        if ($this->source->user_id !== request()->user()->id) {
            abort(401);
        }

        $this->emit("deleteSourceConfirm");
    }

    /**
     * @return void
     */
    public function delete(): void
    {
        if ($this->source->user_id !== request()->user()->id) {
            abort(401);
        }

        $this->source->delete();

        $this->emit("sourceWasDeleted");

        $this->emitTo('livewire-toast', 'show', 'Source has been deleted');
    }

    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire.sources.delete');
    }
}
