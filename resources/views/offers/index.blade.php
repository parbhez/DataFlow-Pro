<x-app-layout>
    <x-slot name="title"> | List Offer</x-slot>

    <x-slot name="styles">

    </x-slot>

    <x-slot name="maincontent">
        <!-- Content -->

        <x-common.filter
            :route="'offers.create'"
            :button="'Add Offer'">
            <!-- Filter -->
            @include('offers.filter')
            <!-- / Filter -->
        </x-common.filter>


        <!-- <div class="container-xxl flex-grow-1 container-p-y"> -->
        <div class="table_card m-5 mt-0 mb-2">
            <!-- Bordered Table -->
            <div class="card" style="border-radius: 0px 0px 5px 5px; border-top:0px;">
                <!-- <h5 class="card-header px-3 py-3 pb-0">Offer List</h5> -->
                <div class="card-body">
                    @include('offers.offer-table')
                </div>
            </div>
            <!--/ Bordered Table -->



        </div>
        <!-- / Content -->
    </x-slot>

    <x-slot name="scripts">
        @include('layouts.scripts.delete-script')

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
    </x-slot>
</x-app-layout>