<div class="d-flex flex-column flex-lg-row justify-content-between mb-0">
    <div class="px-0 py-1 mt-0">
        <label style="color:gray;">
            Show
            <select class="select-page-limit">
                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="200">200</option>
                <option value="300">300</option>
                <option value="500">500</option>
            </select>
            entries
        </label>
    </div>

    <!-- Filter slot can be passed in Blade component -->
    {{ $slot }}

    <div class="w-25">
        <input type="search" placeholder="Search:" class="dataTables_filter_search" aria-controls="">
    </div>
</div>