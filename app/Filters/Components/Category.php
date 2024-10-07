<?php

declare(strict_types=1);

namespace App\Filters\Components;

use Closure;
use App\Constants\Role as RoleConstant;
use Illuminate\Database\Eloquent\Builder;

class Category implements ComponentInterface
{
    public function handle(array $content, Closure $next): mixed
    {
        //For Single category 
        // if (isset($content['params']['category'])) {
        //     $content['builder']->whereHas('categories', function (Builder $query) use ($content) {
        //         $query->where('id', $content['params']['category']);
        //     });
        // }

        //Multiple Category
        // Check if 'categories' parameter is set and not empty
        if (isset($content['params']['categories']) && is_array($content['params']['categories'])) {
            // Use whereIn to handle multiple category IDs
            $content['builder']->whereHas('categories', function (Builder $query) use ($content) {
                $query->whereIn('id', $content['params']['categories']);
            });
        }

        return $next($content);
    }
}
