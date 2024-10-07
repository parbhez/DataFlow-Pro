@props(['route', 'button'])
<div class=" mx-5 mb-0 my-2">
    <div class="card" style="border-radius: 5px 5px 0px 0px; border-bottom:0px;">
        <div class="card-header px-4 py-3 d-flex">
            <div class="row" style="width: 100%;">
                <div class="col-md-6">
                    <h4 class="m-0">Offer List</h4>
                </div>
                <div class="col-md-6">
                    <div class="mx-1" style="float: right;">
                        <a href="{{ route($route) }}" class="btn btn-xs py-2 px-3 btn-primary">{{ $button }}</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body py-0">

            {{ $slot }}


        </div>
    </div>
</div>