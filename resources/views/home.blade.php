<x-app-layout>

    <x-slot name="title">| Home </x-slot>

    <x-slot name="styles">

    </x-slot>



    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Home Page') }}
        </h2>
    </x-slot>


    <!-- body main content -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("This is home page") }}
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <section>
                        <h2 class="flex justify-center">Data Pass parent to Child Component</h2>
                        <hr>
                        @php
                        $users = DB::table('users')->get();
                        @endphp
                        <x-common.alert type="danger" message="Common Something went wrong." :users="$users" />
                    </section>
                </div>

                <h1 class="p-2 mb-4 text-2xl font-bold text-center">Attributes</h1>

                <section class="flex justify-center">

                    <div>
                        <x-button.primary name="Send Me" class="bg-indigo-900" type="submit" masud="parbhez" />
                        <x-link href="google.com" name="Click Link a tag" :active="false" />
                    </div>
                </section>


                <h1 class="p-2 mb-4 text-2xl font-bold text-center">Input / Atributes/ Props / Data Pass</h1>

                <section class="flex justify-center">

                    <div>
                        <x-form.input title="Email" id="email" type="text" name="email" placeholder="Enter Email Address"></x-form.input>

                        <x-form.input title="Password" id="password" type="password" name="password" placeholder="Enter Password"></x-form.input>

                        <x-form.button :type="'submit'" class="bg-indigo-900" :title="'Submit'"></x-form.button>
                    </div>
                </section>

                <hr>
                <br>

                <!-- Card Commponent -->

                <section class="flex justify-center">
                    <x-card.card>

                        {{-- Image --}}
                        <x-slot name="image">
                            <a href="#">
                                <img class="rounded-t-lg" src="https://flowbite.com/docs/images/blog/image-1.jpg" alt="" />
                            </a>
                        </x-slot>

                        {{-- Title --}}
                        <x-slot name="title">
                            <a href="#">
                                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Noteworthy technology acquisitions 2021</h5>
                            </a>
                        </x-slot>

                        {{-- Body --}}
                        <x-slot name="body">
                            Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.Here are the biggest enterprise technology acquisitions of 2021 so far, in reverse chronological order.
                        </x-slot>

                        {{-- Read More --}}
                        <x-slot name="readmore">
                            Read more
                            <svg class="rtl:rotate-180 w-3.5 h-3.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9" />
                            </svg>
                        </x-slot>


                    </x-card.card>
                </section>
            </div>
        </div>




    </div>

    <x-slot name="scripts">
        <script type="module">
            document.addEventListener('DOMContentLoaded', function() {
                $(document).ready(function() {
                    console.log("This is home page");
                });
            }, false);
        </script>
    </x-slot>


</x-app-layout>