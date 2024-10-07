<div>

    @props(['name', 'active'])

    @php
    $classes = ($active ?? false)
    ? 'p-2 duration-500 bg-yellow-500 rounded shadow hover:bg-yellow-800'
    : 'p-2 duration-500 bg-red-500 rounded shadow hover:bg-red-800';
    @endphp

    <a {{ $attributes->class([$classes]) }}> {{ $name }}</a>
</div>