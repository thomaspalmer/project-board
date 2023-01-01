<?php

namespace App\Http\Livewire\Sources;

use App\Models\Source;
use Livewire\{Component, WithPagination};
use Illuminate\View\View;

class Index extends Component
{
    use WithPagination;

    /**
     * @param int $id
     * @return void
     */
    public function toggleActive(int $id): void
    {
        $source = Source::findOrFail($id);

        $source->update([
            'active' => !$source->active,
        ]);
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
