@props(['title','type', 'id','name', 'value', 'placeholder'])

<div class="form-group">
    <label for="email">{{$title ?? ''}}</label>
    <input type="{{$type ?? 'text'}}" value="{{$value ?? ''}}" id="{{$id ?? '' }}" name="{{$name ?? ''}}" class="form-control mb-5" placeholder="{{$placeholder ?? ''}}">
</div>