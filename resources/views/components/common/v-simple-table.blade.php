@props(['headers', 'hasCheckbox'])

<table class="table table-bordered">
    <thead>
        <tr>
            @foreach($headers as $index=>$column)
            <th>
                <span>{{ $column }}</span>
            </th>
            @endforeach
        </tr>
    </thead>
    <tbody class="table-border-bottom-0">
        {{ $slot }}
    </tbody>
</table>