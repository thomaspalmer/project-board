<form wire:submit.prevent="create">
    <x-card>
        <x-card-header>
            <x-card-title>Create Source</x-card-title>
        </x-card-header>

        <x-card-body class="space-y-4">
            <x-field-container
                label="Name"
                name="name"
            >
                <x-input
                    name="name"
                />
            </x-field-container>

            <x-field-container
                label="Vendor"
                name="vendor"
            >
                <div class="grid grid-cols-2 gap-6" x-data>
                    @foreach(config('vendors') as $vendor)
                        <div
                            class="rounded-lg h-20 flex items-center justify-center transform hover:scale-105 transition duration-200 cursor-pointer"
                            :class="$wire.vendor === '{{ $vendor['value'] }}' ? 'bg-gray-200' : 'bg-gray-50'"
                            x-on:click="$wire.setVendor('{{ $vendor['value'] }}')"
                        >
                            <img src="{{ $vendor['src'] }}" class="max-h-10 max-w-10" />
                        </div>
                    @endforeach
                </div>
            </x-field-container>

            <div x-data x-show="$wire.vendor && $wire.vendor.length > 0">
                <x-field-container
                    label="Credentials"
                    name="credentials"
                >
                    <div x-show="$wire.vendor === 'github'" class="space-y-4">
                        <div class="bg-yellow-200 text-yellow-700 p-4 rounded-lg">
                            <p class="text-sm">
                                Please create a GitHub oauth token
                                <a href="https://github.com/settings/personal-access-tokens/new" target="_blank" class="text-indigo-600">here</a>.
                            </p>
                        </div>

                        <x-field-container
                            label="Personal Access Token"
                            name="credentials"
                        >
                            <x-input
                                type="password"
                                name="credentials.personal_access_token"
                            />
                        </x-field-container>

                        <x-field-container
                            label="Expires"
                            name="credentials.expires_at"
                        >
                            <x-input
                                type="date"
                                name="credentials.expires_at"
                            />
                        </x-field-container>
                    </div>

                    <div x-show="$wire.vendor === 'active-collab'" class="space-y-4">
                        <x-field-container
                            label="Company Name"
                            name="credentials.company_name"
                        >
                            <x-input
                                name="credentials.company_name"
                            />
                        </x-field-container>

                        <x-field-container
                            label="Email"
                            name="credentials.email"
                        >
                            <x-input
                                type="email"
                                name="credentials.email"
                            />
                        </x-field-container>

                        <x-field-container
                            label="Password"
                            name="credentials.password"
                        >
                            <x-input
                                type="password"
                                name="credentials.password"
                            />
                        </x-field-container>

                        <x-field-container
                            label="Account Number"
                            name="credentials.account_number"
                        >
                            <x-input
                                name="credentials.account_number"
                            />
                        </x-field-container>
                    </div>

                    <div x-show="$wire.vendor === 'trello'" class="space-y-4">
                        WIP
                    </div>
                </x-field-container>
            </div>
        </x-card-body>

        <x-card-footer class="flex justify-end">
            <x-primary-button>
                Create
            </x-primary-button>
        </x-card-footer>
    </x-card>
</form>
