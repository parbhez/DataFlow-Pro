@props(['limitRoute'])

<div class="d-flex justify-content-between align-items-center">
    <div class="dataTables_info" style="color:#b6bbc5;">
        Showing {{ $meta->firstItem() }} to {{ $meta->lastItem() }} of {{ $meta->total() }} entries
    </div>

    <nav aria-label="Page navigation">
        <ul class="pagination pagination-primary d-flex justify-content-center mb-0">
            <!-- First Page -->
            <li class="page-item {{ $meta->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $meta->url(1) }}">
                    <i class="tf-icon bx bx-chevrons-left"></i>
                </a>
            </li>

            <!-- Previous Page -->
            <li class="page-item {{ $meta->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $meta->previousPageUrl() }}">
                    <i class="tf-icon bx bx-chevron-left"></i>
                </a>
            </li>

            <!-- Page Numbers with offset -->
            @php
            $totalPages = $meta->lastPage();
            $currentPage = $meta->currentPage();
            $offset = 3; // Number of pages before and after the current page
            $start = $currentPage - $offset;
            $end = $currentPage + $offset;

            if ($start < 1) {
                $end +=1 - $start;
                $start=1;
                }

                if ($end> $totalPages) {
                $start -= $end - $totalPages;
                $end = $totalPages;
                }

                if ($start < 1) {
                    $start=1;
                    }
                    @endphp

                    @for ($page=$start; $page <=$end; $page++)
                    <li class="page-item {{ $meta->currentPage() == $page ? 'active' : '' }}">
                    <a class="page-link" href="{{ $meta->url($page) }}">{{ $page }}</a>
                    </li>
                    @endfor

                    <!-- Next Page -->
                    <li class="page-item {{ $meta->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $meta->nextPageUrl() }}">
                            <i class="tf-icon bx bx-chevron-right"></i>
                        </a>
                    </li>

                    <!-- Last Page -->
                    <li class="page-item {{ $meta->hasMorePages() ? '' : 'disabled' }}">
                        <a class="page-link" href="{{ $meta->url($meta->lastPage()) }}">
                            <i class="tf-icon bx bx-chevrons-right"></i>
                        </a>
                    </li>
        </ul>
    </nav>
    <div>
        <label style="color:#b6bbc5;">
            Show
            <select class="select-page-limit" data-limit-route="{{ route($limitRoute) }}">
                <option value="10" {{ request()->input('limit', PAGINATE_LIMIT) == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ request()->input('limit', PAGINATE_LIMIT) == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ request()->input('limit', PAGINATE_LIMIT) == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ request()->input('limit', PAGINATE_LIMIT) == 100 ? 'selected' : '' }}>100</option>
                <option value="200" {{ request()->input('limit', PAGINATE_LIMIT) == 200 ? 'selected' : '' }}>200</option>
                <option value="300" {{ request()->input('limit', PAGINATE_LIMIT) == 300 ? 'selected' : '' }}>300</option>
                <option value="500" {{ request()->input('limit', PAGINATE_LIMIT) == 500 ? 'selected' : '' }}>500</option>
            </select>
            entries
        </label>
    </div>
</div>

<script>
    // $(document).ready(function() {
    //     $('.select-page-limit').on('change', function() {
    //         var limit = $(this).val();
    //         var limitRoute = $(this).data('limit-route');

    //         // Get the current URL and all query parameters
    //         var queryParams = new URLSearchParams(window.location.search);
    //         queryParams.set('limit', limit); // Update the limit parameter

    //         $.ajax({
    //             url: limitRoute + '?' + queryParams.toString(), // Include all query parameters in the request
    //             method: 'GET',
    //             success: function(response) {
    //                 $('#table-container').html(response); // Update table content
    //             },
    //             error: function(xhr) {
    //                 console.error('Error:', xhr.responseText);
    //                 Swal.fire({
    //                     icon: "error",
    //                     title: "Oops...",
    //                     text: "Something went wrong while fetching data!", // More context
    //                 });
    //             }
    //         });
    //     });
    // });

    $(document).ready(function() {
        $('.select-page-limit').on('change', function() {
            var limit = $(this).val();
            var limitRoute = $(this).data('limit-route');
            // Use vanilla JS to set the value of the element with ID 'data-limit'
            document.getElementById('data-limit').value = limit;

            // Get the current URL and all existing query parameters
            var queryParams = new URLSearchParams(window.location.search);

            // Update the limit parameter
            queryParams.set('limit', limit); // Set the new limit

            // If changing the limit, reset the page to 1 (optional, or keep it dynamic based on use case)
            queryParams.set('page', 1); // Reset to page 1 when limit changes (remove if you don't want this)

            // Construct the new URL with all the query parameters
            var newUrl = limitRoute + '?' + queryParams.toString();

            // Perform the AJAX request with the updated URL
            $.ajax({
                url: newUrl, // Use the constructed URL with all query params
                method: 'GET',
                success: function(response) {
                    $('#table-container').html(response); // Update table content

                    // Update the browser's URL without reloading the page
                    window.history.pushState(null, '', newUrl, true);
                },
                error: function(xhr) {
                    console.error('Error:', xhr.responseText);
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Something went wrong while fetching data!", // Error message
                    });
                }
            });
        });
    });
</script>