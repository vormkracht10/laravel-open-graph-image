<?php

namespace Vormkracht10\LaravelOpenGraphImage\Components;

use Illuminate\View\Component;

class LaravelOpenGraphImage extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        dd('test');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('laravel-open-graph-image::components.laravel-open-graph-image');
    }
}
