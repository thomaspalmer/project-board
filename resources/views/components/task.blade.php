<div class="divide-x divide-gray-200">
    @if ($task)
        <div class="flex justify-between items-center px-4 py-2 border-gray-200 {{ $task->high_priority ? 'bg-red-300' : 'bg-gray-50' }}">
            <div
                class="text-md {{ $task->high_priority ? 'text-red-800' : 'text-gray-800' }}">
                {{ $task->title }}
            </div>

            @if(!$task->has_source)
                <div>
                    @livewire("tasks.dropdown-options", [
                        'task' => $task,
                    ])
                </div>
            @endif
        </div>

        <x-card-body>
            <article class="prose">
                @if($task->description_type === \App\Enums\DescriptionTypes::HTML)
                    {!! $task->description !!}
                @elseif ($task->description_type === \App\Enums\DescriptionTypes::Markdown)
                    {!! Str::markdown($task->description) !!}
                @endif
            </article>
        </x-card-body>

        <x-card-footer class="flex justify-between items-center">
            <div class="flex space-x-2">
                <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800">
                     <i class="fa-solid fa-alarm-clock mr-1"></i>
                    <span>{{ $task->due_at->format("d/m/y") }}</span>
                </span>

                <span
                    class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium {{ $task->high_priority ? 'bg-red-300 text-red-800' : 'bg-gray-100 text-gray-800' }}">
                    <i class="fa-solid fa-light-emergency{{ $task->high_priority ? '-on' : '' }} mr-1"></i>
                    <span class="capitalize">{{ $task->priority }}</span>
                </span>

                @if($task->link)
                    <a href="{{ $task->link }}"
                       class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-gray-800">
                        <i class="fa-solid fa-link mr-1"></i>
                        <span>Link</span>
                    </a>
                @endif
            </div>

            <div>
                @if($task->source?->vendor_info)
                    <img src="{{ $task->source?->vendor_info['src'] }}" class="max-w-8 max-h-8" />
                @else
                    <x-logo />
                @endif
            </div>
        </x-card-footer>
    @else
        <x-card-body>
            There is no task to display.
        </x-card-body>
    @endif
</div>
