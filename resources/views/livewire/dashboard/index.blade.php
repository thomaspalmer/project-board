<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="space-y-6">
        @livewire('dashboard.current-priority', [
            'task' => $current,
        ])

        @livewire('dashboard.next-priority', [
            'task' => $next,
        ])
    </div>

    <div>
        @livewire('dashboard.backlog', [
            'tasks' => $backlog,
        ])
    </div>
</div>
