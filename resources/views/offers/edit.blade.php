<x-app-layout>
    <x-slot name="title"> | Edit Offer </x-slot>

    <x-slot name="styles">

        <link rel="stylesheet" href="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/vendor/libs/select2/select2.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/vendor/libs/flatpickr/flatpickr.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/vendor/libs/tagify/tagify.css')}}" />
        <link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}" />

    </x-slot>

    <x-slot name="maincontent">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 breadcrumb-wrapper mb-4 text-center">Update Offer</h4>
            <div class="row mb-4">
                <!-- Browser Default -->
                <div class="col-md mb-4 mb-md-0">
                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('offers.update', $offer->id) }}" method="post" class="browser-default-validation" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <!-- //method spoofing  -->

                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-name">Title <span class="text-danger">*</span></label>
                                    <input
                                        type="text"
                                        class="form-control"
                                        id="basic-default-name"
                                        name="title"
                                        value="{{ old('title', $offer->title) }}"
                                        placeholder="Title" />
                                    @error('title')
                                    <p class="text-danger p-2">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-email">Price <span class="text-danger">*</span></label>
                                    <input
                                        type="text"
                                        id="basic-default-email"
                                        class="form-control"
                                        name="price"
                                        placeholder="Price"
                                        value="{{ old('price', $offer->price) }}" />
                                    @error('price')
                                    <p class="text-danger p-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-category">Category <span class="text-danger">*</span></label>
                                    <select class="form-select" name="categories[]" id="select-category" autocomplete="off" multiple>
                                        <option value="">Select Categories...</option>
                                        @foreach($categories as $category)
                                        <option value="{{$category->id}}" {{ in_array($category->id, old('categories', $offer->categories->pluck('id')->toArray())) ? 'selected' : '' }}> {{$category->title}} </option>
                                        @endforeach
                                    </select>
                                    @error('categories')
                                    <p class="text-danger p-2">{{ $message }}</p>
                                    @enderror
                                </div>



                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-location">Location <span class="text-danger">*</span></label>
                                    <select class="select2 form-select" name="locations[]" id="basic-default-location" multiple>
                                        <option value="">Select Locations...</option>
                                        @foreach($locations as $location)
                                        <option value="{{$location->id}}" {{ in_array($location->id, old('locations', $offer->locations->pluck('id')->toArray())) ? 'selected' : '' }}>{{ $location->title }}</option>
                                        @endforeach

                                    </select>
                                    @error('locations')
                                    <p class="text-danger p-2">{{ $message }}</p>
                                    @enderror
                                </div>


                                <div class="mb-3 image-preview">
                                    <label class="form-label" for="basic-default-upload-file">Image</label>
                                    <img src="{{ asset($offer->image_url) }}" alt="" width="300" height="300" class="mr-3">
                                    <input type="file" name="image" class="image-upload-input form-control" id="basic-default-upload-file" />
                                    @error('image')
                                    <p class="text-danger p-2">{{ $message }}</p>
                                    @enderror
                                </div>


                                <div class="mb-3">
                                    <label class="form-label" for="basic-default-bio">Description <span class="text-danger">*</span></label>
                                    <textarea
                                        class="form-control"
                                        name="description"
                                        id="basic-default-bio"
                                        placeholder="Description"
                                        rows="3">{{ old('description', $offer->description) }}</textarea>
                                    @error('description')
                                    <p class="text-danger p-2">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <button type="submit" class="btn btn-primary ml-3">Submit</button>
                                        <a href="{{auth()->user()->isAdmin() ? route('offers.index') : route('offers.my')}}" class="btn btn-danger ">Cancle</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- /Browser Default -->


            </div>

        </div>
        <!-- / Content -->
    </x-slot>

    <x-slot name="scripts">
        @include('layouts.scripts.image-upload-preview-script')

        <script>
            $(document).ready(function() {
                new TomSelect("#select-category", {
                    plugins: ['remove_button'],
                    maxItems: 20,
                    onItemAdd: function() {
                        this.setTextboxValue(''); // Clear the text box after adding an item
                    }
                });
            });
        </script>
        <!-- Vendors JS -->
        <script src="{{asset('assets/vendor/libs/select2/select2.js')}}"></script>
        <script src="{{asset('assets/vendor/libs/bootstrap-select/bootstrap-select.js')}}"></script>
        <script src="{{asset('assets/vendor/libs/moment/moment.js')}}"></script>
        <script src="{{asset('assets/vendor/libs/flatpickr/flatpickr.js')}}"></script>
        <script src="{{asset('assets/vendor/libs/tagify/tagify.js')}}"></script>
        <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js')}}"></script>
        <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js')}}"></script>
        <script src="{{asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js')}}"></script>
        <script src="{{asset('/assets/js/forms-selects.js')}}"></script>
        <!-- Page JS -->
        <!-- <script src="{{asset('assets/js/form-validation.js')}}"></script> -->
    </x-slot>
</x-app-layout>