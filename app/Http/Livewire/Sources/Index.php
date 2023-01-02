<?php

namespace App\Http\Livewire\Sources;

use App\Models\Source;
use Livewire\{Component, WithPagination};
use Illuminate\View\View;

class Index extends Component
{
    use WithPagination;

    /**
     * @var string[]
     */
    protected $listeners = [
        'sourceWasDeleted' => '$refresh',
    ];

    /**
     * @param int $id
     * @return void
     */
    public function toggleActive(int $id): void
    {
        $source = Source::findOrFail($id);

        if ($source->user_id !== request()->user()->id) {
            abort(401);
        }

        $source->update([
            'active' => !$source->active,
        ]);

        $this->emitTo('livewire-toast', 'show', 'Source has been ' . (!$source->active ? 'enabled' : 'disabled'));
    }

    /**
     * @return View
     */
    public function render(): View
    {
        return view('livewire.sources.index', [
            'sources' => Source::paginate(10)
        ]);
    }
}
