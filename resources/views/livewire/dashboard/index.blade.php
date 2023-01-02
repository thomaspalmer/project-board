<div wire:poll.60000ms>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-6">
            @livewire('dashboard.current-priority', [
                'task' => $current,
            ], key($current->id))

            @livewire('dashboard.next-priority', [
                'task' => $next,
            ], key($next->id))
        </div>

        <div>
            @livewire('dashboard.backlog', [
                'tasks' => $backlog,
            ], key($backlog->count()))
        </div>
    </div>
</div>
