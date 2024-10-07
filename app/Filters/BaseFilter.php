<?php

namespace App\Filters;

use Illuminate\Pipeline\Pipeline;

abstract class BaseFilter
{
    abstract protected function getFilters(): array;

    public function getResults($contents)
    {
        $result = app(Pipeline::class)
            ->send($contents)
            ->through($this->getFilters())
            ->then(fn($contents) => $contents['builder']);

        // Check if the request is for general (PDF, Excel, report) and avoid applying the limit
        if (request()->has('is_general')) {
            // Don't limit the results if it's a PDF generation
            return $result->get();
        } else {
            // Apply the limit for non-PDF requests
            $limit = $contents['limit'] ?? 10; // Use the limit from the passed contents array. Default limit if not provided
            return $result->paginate($limit)->withQueryString()->appends(request()->query());
            // return $result->paginate($limit)->appends(request()->query());
        }
    }
}
