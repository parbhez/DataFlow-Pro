<?php

namespace App\View\Components\Common;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DefaultModal extends Component
{

    public $id;
    public $title;
    public $footer;


    /**
     * Create a new component instance.
     *
     * @param string $id
     * @param string $title
     * @param string $body
     * @param string|null $footer
     */
    public function __construct($id, $title, $footer = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->footer = $footer;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.common.default-modal');
    }
}
