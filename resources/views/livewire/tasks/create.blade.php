<div
    x-cloak
    x-data="{ isOpen: false }"
    x-show="isOpen"
    @keydown.escape.window="isOpen = false"
    x-init="
        window.livewire.on('createNewTask', () => isOpen = true)
        window.livewire.on('taskWasCreated', () => isOpen = false)
    "
    class="relative z-10"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
>
    <div
        x-show.transition.opacity="isOpen"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
    ></div>

    <div
        x-show.transition.opacity="isOpen"
        class="fixed inset-0 z-10 overflow-y-auto"
    >
        <div class="flex min-h-full items-end justify-center p-4 sm:items-center sm:p-0">
            <div class="max-w-xl w-full">
                <form wire:submit.prevent="create">
                    <x-card>
                        <x-card-header>
                            Create Task
                        </x-card-header>

                        <x-card-body class="space-y-4">
                            <x-field-container
                                label="Title"
                                name="title"
                            >
                                <x-input name="title" />
                            </x-field-container>

                            <x-field-container
                                label="Priority"
                                name="priority"
                            >
                                <x-select
                                    name="priority"
                                    :options="\App\Enums\Priorities::cases()"
                                />
                            </x-field-container>

                            <x-field-container
                                label="Due At"
                                name="due_at"
                            >
                                <x-input type="date" name="due_at" />
                            </x-field-container>

                            <x-field-container
                                label="Description"
                                name="description"
                            >
                                <x-textarea name="description" />
                            </x-field-container>
                        </x-card-body>

                        <x-card-footer class="flex justify-end space-x-2">
                            <x-primary-button click="isOpen = false">
                                Cancel
                            </x-primary-button>
                            <x-primary-button>
                                Create
                            </x-primary-button>
                        </x-card-footer>
                    </x-card>
                </form>
            </div>
        </div>
    </div>
</div>
