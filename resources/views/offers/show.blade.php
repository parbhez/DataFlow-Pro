<x-app-layout>
    <x-slot name="title"> | Offer</x-slot>

    <x-slot name="styles">


    </x-slot>

    <x-slot name="maincontent">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 breadcrumb-wrapper mb-4 text-center">Show Offer</h4>

            <div class="row mb-5">
                <div class="col-md">
                    <div class="card mb-4">

                        <div class="card-header header-elements">
                            <span class="me-2">Image</span>
                        </div>
                        <div class="card-body">
                            <img src="{{ asset($offer->image_url) }}" alt="not found" width="200" height="100">
                        </div>


                        <div class="card-header header-elements">
                            <span class="me-2">Title</span>
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{ $offer->title}}</p>
                        </div>

                        <div class="card-header header-elements">
                            <span class="me-2">Price</span>
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{ $offer->price}}</p>
                        </div>

                        <div class="card-header header-elements">
                            <span class="me-2">Created By</span>
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{ $offer->author->name}}</p>
                        </div>

                        <div class="card-header header-elements">
                            <span class="me-2">Category</span>
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{getTitles($offer->categories)}}</p>
                        </div>

                        <div class="card-header header-elements">
                            <span class="me-2">Location</span>
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{ getTitles($offer->locations)}}</p>
                        </div>

                        <div class="card-header header-elements">
                            <span class="me-2">Description</span>
                        </div>
                        <div class="card-body">
                            <p class="card-text">{{ $offer->description}}</p>
                        </div>
                    </div>


                </div>

                <div class="w-100"></div>


            </div>
        </div>
        <!-- / Content -->
    </x-slot>

    <x-slot name="scripts">


    </x-slot>
</x-app-layout>