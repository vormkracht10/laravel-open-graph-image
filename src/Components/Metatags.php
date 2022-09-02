<?php

namespace Vormkracht10\LaravelOpenGraphImage\Components;

use Illuminate\View\Component;

class Metatags extends Component
{
    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('open-graph-image::components.metatags');
    }
}
