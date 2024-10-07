<form action="{{auth()->user()->isAdmin() ? route('offers.index') : route('offers.my')}}" method="GET">
    <div class="row">
        <div class="col my-2">
            <select class="form-select" name="status" id="select-status" autocomplete="off">
                <option value="" selected>Select status...</option>
                @foreach(\App\Constants\Status::LIST as $status)
                <option
                    {{ request()->query('status') === $status ? 'selected' : '' }}
                    value="{{ $status }}">{{ $status }}</option>
                @endforeach
            </select>
        </div>

        <input type="hidden" id="data-limit" name="limit" value="{{ request('limit', 10) }}">


        <div class="col my-2">
            <select class="form-select" name="location" id="select-location" autocomplete="off">
                <option disabled selected>Select location...</option>
                @foreach($locations as $location)
                <option
                    {{ request()->query('location') == $location->id ? 'selected' : '' }}
                    value="{{ $location->id }}">{{ $location->title }}</option>
                @endforeach
            </select>
        </div>

        <!-- <div class="col my-2">
    <select class="form-select" name="category" id="select-category" autocomplete="off">
        <option disabled selected>Select category...</option>
        @foreach($categories as $category)
        <option
            {{ request()->query('category') == $category->id ? 'selected' : '' }}
            value="{{ $category->id }}">{{ $category->title }}</option>
        @endforeach
    </select>
</div> -->

        <div class="col my-2">
            <select class="form-select" name="categories[]" id="select-category" autocomplete="off" multiple>
                <option disabled value="">Select category...</option>
                @foreach($categories as $category)
                <option
                    {{ is_array(request()->query('categories')) && in_array($category->id, request()->query('categories')) ? 'selected' : '' }}
                    value="{{ $category->id }}">{{ $category->title }}</option>
                @endforeach
            </select>
        </div>

        <div class="col my-2">
            <input
                type="text"
                id="basic-default-email"
                class="form-control"
                name="title"
                placeholder="Search by title..."
                value="{{ request()->query('title') }}" />
        </div>
    </div>



    <div class="mx-auto d-flex my-2 justify-content-center">
        <div class="mx-1">
            <button type="submit" class="btn btn-xs py-2 btn-primary">Search</button>
        </div>
        <div class="mx-1">
            <a href="{{ url()->current() }}" class="btn btn-xs py-2 btn-danger">Clear filter</a>
        </div>
        <div class="mx-1">
            <a href="{{ route('offers.generate.pdf', array_merge(request()->query(), ['is_general' => true])) }}" target="_blank" class="btn btn-xs py-2 btn-success">PDF</a>
        </div>
        <div class="mx-1">
            <a href="{{ route('offers.generate.excel', array_merge(request()->query(), ['is_general' => true])) }}" target="_blank" class="btn btn-xs py-2 btn-secondary">Export to Excel</a>
        </div>

        <div class="mx-1">
            <a href="#" data-bs-toggle="modal" data-bs-target="#bulkImportModal" class="btn btn-xs py-2 btn-secondary">Bulk Import</a>
        </div>
    </div>
</form>





<!-- Dynamic Modal Component -->
<x-common.default-modal id="bulkImportModal" title="Offer Bulk Import">
    <!-- Body Content Slot -->
    <form method="POST" action="{{ route('offers.bulk.import') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="file" class="form-label">Upload Excel File</label>
            <input type="file" id="file" name="file" class="form-control" required>
            @error('file')
            <p class="text-danger p-2">{{ $message }}</p>
            @enderror
        </div>

        <!-- Move the footer inside the form so the submit button is part of the form -->
        <div class="modal-footer">
            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Upload</button>
        </div>
    </form>
</x-common.default-modal>