<div class="alert alert-{{ $type }}">
    {{ $message }}

    <hr>
    <ul>
        @foreach($users as $key=>$row)
        <li>{{ $row->name }}</li>
        @endforeach
    </ul>




</div>