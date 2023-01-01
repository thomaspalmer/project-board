<x-card>
    <x-card-header>
        Back Log
    </x-card-header>

    <div class="divide-y divide-gray-300">
        @foreach ($tasks as $task)
            <x-task :task="$task" />
        @endforeach
    </div>
</x-card>
