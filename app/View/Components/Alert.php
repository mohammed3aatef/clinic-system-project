<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    public $duration;

    public function __construct($duration = 1000)
    {
        $this->duration = $duration;
    }

    public function render()
    {
        return view('components.alert');
    }
}

