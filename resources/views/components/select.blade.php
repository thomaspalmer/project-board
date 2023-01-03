<div>
    <select
        wire:model.lazy="{{ $name }}"
        id="{{ $name }}"
        name="{{ $name }}"
        {{ $required && "required" }}
        class="block w-full rounded-md border-gray-300 py-2 pl-3 pr-10 text-base focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm @error($name) border-red-300 text-red-900 placeholder-red-300 focus:border-red-300 focus:ring-red @enderror"
    >
        <option value=""></option>

        @foreach ($options as $option)
            <option value="{{ $option->value }}">{{ $option->name }}</option>
        @endforeach
    </select>
</div>
