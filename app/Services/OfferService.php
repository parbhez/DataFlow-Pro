<?php

namespace App\Services;

use App\Models\Offer;
use App\Filters\OfferFilter;
use App\Events\UserActivityEvent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OfferService
{
    // public function store(array $data)
    // {
    //     DB::transaction(function () use ($data) {
    //         $data = array_merge([
    //             'author_id' => auth()->user()->id,
    //         ], $data);

    //         $offer = Offer::create($data);

    //         $offer->categories()->sync($data['categories']);
    //         $offer->locations()->sync($data['locations']);
    //     }, 5);
    // }


    public function store(array $data, $image = null)
    {
        // Wrap the operation in a database transaction
        DB::transaction(function () use ($data, $image) {
            // Add the author's ID to the data array
            $data = array_merge([
                'author_id' => auth()->user()->id,
            ], $data);

            // Create the offer with the given data
            $offer = Offer::create($data);

            // Sync categories if provided
            if (isset($data['categories']) && is_array($data['categories'])) {
                $offer->categories()->sync($data['categories']);
            }

            // Sync locations if provided
            if (isset($data['locations']) && is_array($data['locations'])) {
                $offer->locations()->sync($data['locations']);
            }

            if (isset($image)) {
                $offer->addMedia($image)
                    ->toMediaCollection();
            }

            // Trigger event for offer creation
            event(new UserActivityEvent(auth()->user(), "Created a new offer with title: {$offer->title}", 'create'));
        }, 5); // Retry the transaction up to 5 times in case of deadlock
    }

    public function update(Offer $offer, array $data, $image = null)
    {
        // Wrap the operation in a database transaction
        DB::transaction(function () use ($data, $image, $offer) {
            // Add the author's ID to the data array
            $data = array_merge([
                'author_id' => auth()->user()->id,
            ], $data);

            // Create the offer with the given data
            $offer = tap($offer)->update($data);

            // Sync categories if provided
            if (isset($data['categories']) && is_array($data['categories'])) {
                $offer->categories()->sync($data['categories']);
            }

            // Sync locations if provided
            if (isset($data['locations']) && is_array($data['locations'])) {
                $offer->locations()->sync($data['locations']);
            }

            if (isset($image)) {
                $offer->addMedia($image)
                    ->toMediaCollection();
            }

            // Trigger event for offer creation
            event(new UserActivityEvent(auth()->user(), "Update a new offer with title: {$offer->title}", 'update'));
        }, 5); // Retry the transaction up to 5 times in case of deadlock
    }

    // public function get(array $queryParams = [])
    // {
    //     $queryBuilder = Offer::with(['author', 'categories', 'locations'])->latest();
    //     $offers = resolve(OfferFilter::class)->getResults([
    //         'builder' => $queryBuilder,
    //         'params' => $queryParams,
    //     ]);

    //     return $offers;
    // }

    public function get(array $queryParams = [], $limit = PAGINATE_LIMIT, $isMyOffer = false)
    {
        $queryBuilder = Offer::with(['author', 'categories', 'locations'])->orderBy('id', 'asc');

        // Apply the 'author_id' condition only if $isMyOffer is true
        if ($isMyOffer) {
            $queryBuilder->where('author_id', auth()->user()->id);
        }

        $offers = resolve(OfferFilter::class)->getResults([
            'builder' => $queryBuilder,
            'params' => $queryParams,
            'limit'  => $limit
        ]);

        return $offers;
    }

    // public function getMine(array $queryParams = [], $limit = PAGINATE_LIMIT)
    // {
    //     $queryBuilder = Offer::with(['author', 'categories', 'locations'])
    //         ->where('author_id', auth()->user()->id)
    //         ->latest();
    //     $offers = resolve(OfferFilter::class)->getResults([
    //         'builder' => $queryBuilder,
    //         'params' => $queryParams,
    //         'limit'  => $limit
    //     ]);

    //     return $offers;
    // }

    public function destroy($offer)
    {
        $offer->update([
            'deleted_by' => auth()->user()->id,
            'deleted_at' => now()
        ]);

        Log::info('successfully deleted');
    }
}
