<?php

namespace App\View\Components\Common;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Pagination\LengthAwarePaginator;

class VPaginate extends Component
{
    public LengthAwarePaginator $meta;

    public function __construct(LengthAwarePaginator $meta)
    {
        $this->meta = $meta;
    }
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.common.v-paginate');
    }
}
