<{{ $type === "link" ? "a" : "button" }}
    class="{{ $class }}"
{!! isset($click) ? "@click=\"" . $click . "\"" : "" !!}
{!! isset($href) ? "href=\"" . $href . "\"" : "" !!}
>
{!! $slot !!}
</{{ $type === "link" ? "a" : "button" }}>
