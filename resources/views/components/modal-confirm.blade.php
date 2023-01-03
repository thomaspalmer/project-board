<div
    x-cloak
    x-data="{ isOpen: false }"
    x-show="isOpen"
    @keydown.escape.window="isOpen = false"
    x-init="
        window.livewire.on('{{ $openEvent }}', () => isOpen = true)
        window.livewire.on('{{ $closeEvent }}', () => isOpen = false)
    "
    class="relative z-10"
    aria-labelledby="modal-title"
    role="dialog"
    aria-modal="true"
>
    <div
        x-show.transition.opacity="isOpen"
        class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

    <div
        class="fixed inset-0 z-10 overflow-y-auto"
        x-show.transition.opacity="isOpen"
    >
        <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
            <div class="relative transform overflow-hidden rounded-lg bg-white px-4 pt-5 pb-4 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-lg sm:p-6">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fa-solid fa-exclamation-circle text-red-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg font-medium leading-6 text-gray-900" id="modal-title">{{ $title }}</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">{{ $description }}</p>
                        </div>
                    </div>
                </div>
                <div class="mt-5 sm:mt-4 sm:flex space-x-6 sm:justify-end">
                    <x-primary-button click="isOpen = false">Cancel</x-primary-button>
                    <x-danger-button click="{{ $confirmClick }}">Continue</x-danger-button>
                </div>
            </div>
        </div>
    </div>
</div>
