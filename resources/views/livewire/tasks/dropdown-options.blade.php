<div
    x-cloak
    x-data="{ isOpen: false }"
    x-init="
        window.livewire.on('setEditTask', () => isOpen = false)
        window.livewire.on('setCompleteTask', () => isOpen = false)
        window.livewire.on('setDeleteTask', () => isOpen = false)
    "
    class="relative inline-block text-left"
>
    <div>
        <button
            @click="isOpen = !isOpen"
            type="button"
            class="flex items-center rounded-full text-gray-400 hover:text-gray-600 focus:test-gray-500"
            id="menu-button"
            aria-expanded="true"
            aria-haspopup="true"
        >
            <span class="sr-only">Open options</span>
            <i class="fa-solid fa-ellipsis-vertical"></i>
        </button>
    </div>

    <div
        x-show="isOpen"
        @click.away="isOpen = false"
        class="absolute right-0 z-10 mt-2 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
        role="menu"
        aria-orientation="vertical"
        aria-labelledby="menu-button"
        tabindex="-1"
    >
        <div class="py-1 divide-y divide-gray-200" role="none">
            <div>
                <button @click="$wire.emit('setEditTask', {{ $task->id }})" class="w-full text-left text-gray-700 block px-4 py-2 text-sm">Edit</button>
                <button @click="$wire.emit('setCompleteTask', {{ $task->id }})" class="w-full text-left text-gray-700 block px-4 py-2 text-sm">Complete</button>
            </div>

            <div>
                <button @click="$wire.emit('setDeleteTask', {{ $task->id }})" class="w-full text-left text-gray-700 block px-4 py-2 text-sm">Delete</button>
            </div>
        </div>
    </div>
</div>
