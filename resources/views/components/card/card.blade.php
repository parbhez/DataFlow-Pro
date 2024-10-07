<div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
    @isset($image)
    {{ $image }}
    @endisset
    <div class="p-5">

        @isset($title)
        {{ $title }}
        @endisset

        <p class="mb-3 font-normal text-green-700 dark:text-gray-400">
            @isset($body)
            {{ $body }}
            @endisset
        </p>


        <a href="#" class="inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            @isset($readmore)
            {{ $readmore }}
            @endisset
        </a>

    </div>
</div>