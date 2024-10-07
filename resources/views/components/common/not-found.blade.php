@props(['message', 'height' => 'auto', 'icon' => 'far fa-layer-plus'])

<div class="d-flex flex-column align-items-center justify-content-center" style="height: {{ $height }};">
    @if($icon)
    <p class="h3 font-weight-bolder">
        <img src="{{ asset('assets/img/no-result.png') }}" alt="No data" height="120" width="120" />
    </p>
    @endif

    <slot>
        <p class="font-weight-bold text-light-grey" style="font-size: 1rem;">
            {!! $message !!}
        </p>
    </slot>
</div>