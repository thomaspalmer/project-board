<div>
    <x-label for="{{ $name }}">
        {{ $label }}
    </x-label>

    <div class="mt-1 rounded-md">
        {!! $slot !!}
    </div>

    @error($name)
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
