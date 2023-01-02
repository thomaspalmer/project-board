<x-card>
    <x-card-header>
        Back Log
    </x-card-header>

    <div class="divide-y divide-gray-300">
        @if($tasks->isNotEmpty())
            @foreach ($tasks as $task)
                <x-task
                    wire:key="{{ $task->id }}"
                    :task="$task"
                />
            @endforeach
        @else
            <x-card-body>
                There are no tasks to display
            </x-card-body>
        @endif
    </div>
</x-card>
