<div class="table-responsive text-nowrap table-container" id="table-container">

    <x-common.v-simple-table :headers="[
        '#SL.',
        'Created by',
        'Title', 
        'Image', 
        'Price', 
        'Category', 
        'Location', 
        'Status',
        'Actions',
    ]">

        @foreach($offers as $key=>$offer)
        <tr>
            <td>{{ $offer->id }} - {{ ($offers->perPage() * ($offers->currentPage() - 1)) + ($key + 1) }}</td>

            <td>
                <img src="{{ asset($offer->author->image_url) }}" alt="Avatar" class="rounded-circle" /> <strong>{{ $offer->author->name}}</strong>
            </td>
            <td>
                <a href="{{ route('offers.show', $offer) }}"><span>{{ \Illuminate\Support\Str::words($offer->title, 3, '...') }}</span></a>
            </td>
            <td>
                <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                    <li
                        data-bs-toggle="tooltip"
                        data-popup="tooltip-custom"
                        data-bs-placement="top"
                        class="avatar avatar-xs pull-up"
                        title="Lilian Fuller">
                        <img src="{{ asset($offer->image_url) }}" alt="Avatar" class="rounded-circle" />
                    </li>
                </ul>
            </td>
            <td>{{ $offer->price}}</td>
            <td>{{ getTitles($offer->categories) }}</td>
            <td>{{ getTitles($offer->locations) }}</td>
            <td>
                <span class="badge {{ $offer->status === \App\Constants\Status::DRAFT ? 'bg-label-warning' : 'bg-label-success' }} me-1">
                    {{ $offer->status }}
                </span>
            </td>

            <td>
                <div class="dropdown">
                    <button
                        type="button"
                        class="btn p-0 dropdown-toggle hide-arrow"
                        data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="{{ route('offers.edit', $offer->id) }}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                        <!-- <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-1"></i> Delete</a> -->
                        <!-- <form action="{{ route('offers.destroy', $offer->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="dropdown-item"><i class="bx bx-trash me-1"></i>Delete</button>
                        </form> -->
                        <button
                            data-delete-route="{{ route('offers.destroy', $offer->id) }}" class="delete-item-btn dropdown-item"><i class="bx bx-trash me-1"></i>Delete</button>
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
    </x-common.v-simple-table>


    @if ($offers->count() <= 0)
        <x-common.not-found
        class="py-5"
        message='<h6 class="text-center" style="font-size: 11px;">Sorry! No data available right now.</h6>'
        height="300px"
        icon="true">
        </x-common.not-found>
        @endif

        <!-- Pagination Links Start-->
        <div class="p-4 mt-3">
            @if(auth()->user()->isAdmin())
            <x-common.v-paginate :meta="$offers" :limitRoute="'offers.index'"></x-common.v-paginate>
            @else
            <x-common.v-paginate :meta="$offers" :limitRoute="'offers.my'"></x-common.v-paginate>
            @endif
        </div>
        <!-- Pagination Links End-->
</div>