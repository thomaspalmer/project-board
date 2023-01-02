<div>
    <x-alert />

    @livewire('sources.delete')

    <x-card>
        <x-card-header class="flex justify-between items-center">
            <x-card-title>
                Sources
            </x-card-title>

            <x-primary-button href="{{ route('sources.create') }}" type="link">
                Create
            </x-primary-button>
        </x-card-header>

        @if($sources->count() === 0)
            <x-card-body>
                <p>
                    There are no items to display.
                </p>
            </x-card-body>
        @else
            <x-table>
                <x-thead>
                    <tr>
                        <x-th>Name</x-th>
                        <x-th>Vendor</x-th>
                        <x-th>Active</x-th>
                        <x-th></x-th>
                    </tr>
                </x-thead>

                <tbody>
                @foreach($sources as $source)
                    <tr>
                        <x-td>{{$source->name}}</x-td>
                        <x-td>{{$source->vendor->name}}</x-td>
                        <x-td>{{$source->active ? "Yes" : "No"}}</x-td>
                        <x-td width="1">
                            <div class="flex space-x-0.5" x-data>
                                <x-primary-button click="$wire.toggleActive({{ $source->id }})">
                                    <i class="fa-solid {{ $source->active ? "fa-times" : "fa-check" }}"></i>
                                </x-primary-button>
                                <x-danger-button click="window.livewire.emit('setDeleteSource', {{ $source->id }})">
                                    <i class="fa-solid fa-trash"></i>
                                </x-danger-button>
                            </div>
                        </x-td>
                    </tr>
                @endforeach
                </tbody>
            </x-table>
        @endif

        @if($sources->hasPages())
            <x-card-footer>
                {!! $sources->links() !!}
            </x-card-footer>
        @endif
    </x-card>
</div>
