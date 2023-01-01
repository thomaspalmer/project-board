<div>
    @foreach(['success', 'warning', 'error'] as $type)
        @if (session()->has($type))
            <div class="rounded-md {{ $type === "success" ? "bg-green-300" : "" }} {{ $type === "warning" ? "bg-yellow-300" : "" }} {{ $type === "error" ? "bg-red-300" : "" }} bg-opacity-25 p-4">
                <div class="flex">
                    <div class="flex-shrink-0 text-green-400">
                        @switch($type)
                            @case("success")
                            <i class="fa-solid fa-check"></i>
                            @break
                            @case("warning")
                            <i class="fa-solid fa-exclamation-circle"></i>
                            @break
                            @case("error")
                            <i class="fa-solid fa-times"></i>
                            @break
                        @endswitch
                    </div>

                    <div class="ml-3">
                        <h3 class="text-sm leading-5 font-medium {{ $type === "success" ? "text-green-800" : "" }} {{ $type === "warning" ? "text-yellow-800" : "" }} {{ $type === "error" ? "text-red-800" : "" }}">
                            {{ session($type) }}
                        </h3>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>
