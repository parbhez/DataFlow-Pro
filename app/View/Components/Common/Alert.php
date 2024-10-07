<?php

namespace App\View\Components\Common;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    public $type;
    public $message;
    public $users;

    /**
     * Create a new component instance.
     *
     * @param string $type
     * @param string $message
     * @param array $users
     */
    public function __construct($type = 'success', $message = 'I am saying from Classed based Alert Component', $users = [])
    {
        $this->type = $type;
        $this->message = $message;
        $this->users = $users;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.common.alert');
    }
}
