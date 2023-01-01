<a
    href="{{ $href }}"
    {!! isset($onclick) ? 'onclick="' . $onclick . '"' : ''  !!}
    class="font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150"s
>
    {!! $slot !!}
</a>
