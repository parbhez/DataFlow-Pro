<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Offer extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    use SoftDeletes;


    public const PLACEHOLDER_IMAGE_PATH = 'assets/img/placeholders/placeholder_1.jpg';


    protected $fillable = [
        'title',
        'price',
        'description',
        'author_id',
        'status',
        'deleted_by',
        'deleted_at'
    ];



    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function locations(): BelongsToMany
    {
        return $this->belongsToMany(Location::class);
    }

    /**
     * Get the URL of the offer's image for web usage.
     *
     * This method checks if the offer has any associated media. 
     * If media is present, it returns the first media URL which 
     * can be used to display the image in web applications.
     * Otherwise, it returns a placeholder image path.
     *
     * @return string The URL of the offer's image or a placeholder image path.
     */
    public function getImageUrlAttribute(): string
    {
        //output: http://isp-management.test/storage/1/461498677_392562930558937_7564458385649281082_n.jpg
        return $this->hasMedia()
            ? $this->getFirstMediaUrl()
            : self::PLACEHOLDER_IMAGE_PATH;
    }

    /**
     * Get the file path of the offer's image for Excel exports.
     *
     * This method checks if the offer has any associated media. 
     * If media is present, it returns the full file path of the first 
     * media item, which is necessary for file operations such as 
     * inserting images into an Excel file. 
     * Otherwise, it returns a placeholder image path.
     *
     * @return string The file path of the offer's image or a placeholder image path.
     */
    public function getExcelImageUrlAttribute(): string
    {
        //output: E:\laragon\www\isp-management\storage\app/public\1/461498677_392562930558937_7564458385649281082_n.jpg
        if ($this->hasMedia()) {
            return $this->getFirstMedia()->getPath(); // Use getPath() to get the server path
        }
        return self::PLACEHOLDER_IMAGE_PATH; // Return the placeholder if no media
    }

    // Optional: Register media collections or conversions
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('offers')
            ->useDisk('public') // Use the 'public' disk for media storage
            ->singleFile(); // Ensure only one image per offer
    }
}
