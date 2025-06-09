<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View; // Import View

class AppMusahilLayout extends Component
{
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('layouts.app-musahil'); // <-- Ini menunjuk ke file Blade layout yang baru dibuat
    }
}