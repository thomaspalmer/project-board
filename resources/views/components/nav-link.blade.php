<{{ isset($href) ? "a" : "button" }}
    {!! isset($href) ? "href=\"" . $href . "\"" : "" !!}
    {!! isset($onclick) ? "onclick=\"" . $onclick . "\"" : ""  !!}
    {!! isset($click) ? "@click.prevent=\"" . $click . "\"" : "" !!}
    class="cursor-pointer font-medium text-indigo-600 hover:text-indigo-500 focus:outline-none focus:underline transition ease-in-out duration-150"
>
    {!! $slot !!}
</{{ isset($href) ? "a" : "button" }}>
