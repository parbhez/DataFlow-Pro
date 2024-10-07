<script>
    // $(document).ready(function() {
    //     $('.select-page-limit').on('change', function() {
    //         var limit = $(this).val();
    //         var limitRoute = $(this).data('limit-route');
    //         console.log(limit);

    //         $.ajax({
    //             url: limitRoute, // Replace with your route
    //             method: 'GET',
    //             data: {
    //                 limit: limit
    //             },
    //             success: function(response) {
    //                 // console.log(response);
    //                 // return false;
    //                 $('#offer-table-container').html(response); // Update table content
    //             },
    //             error: function(xhr) {
    //                 console.error('Error:', xhr.responseText);
    //             }
    //         });
    //     });
    // });

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
    //                 $('#offer-table-container').html(response); // Update table content
    //             },
    //             error: function(xhr) {
    //                 console.error('Error:', xhr.responseText);
    //                 Swal.fire({
    //                     icon: "error",
    //                     title: "Oops...",
    //                     text: "Something went wrong!",
    //                     footer: '<a href="#">Why do I have this issue?</a>'
    //                 });
    //             }
    //         });
    //     });
    // });

    $(document).ready(function() {
        $('.delete-item-btn').on('click', function(e) {
            e.preventDefault();

            const deleteRoute = $(this).data('delete-route');

            Swal.fire({
                title: 'Are you sure?',
                text: 'This action can not be undone!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#d33',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Deleting item...',
                        text: 'Please wait while we are deleting the item!',
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    $.ajax({
                        url: deleteRoute,
                        type: 'DELETE',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            Swal.fire({
                                title: 'Deleted successfully!',
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 1000
                            }).then(() => {
                                location.reload();
                            });
                        },
                        error: function(error) {
                            Swal.fire({
                                title: 'Error processing!',
                                text: 'Please try again!',
                                icon: 'error'
                            });
                        }
                    });
                }
            });
        });
    });
</script>