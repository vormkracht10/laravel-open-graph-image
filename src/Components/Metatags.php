<?php

namespace Vormkracht10\LaravelOpenGraphImage\Components;

use Illuminate\View\Component;

class Metatags extends Component
{
    public $title;

    public $subtitle;

    public function __construct(string $title, string $subtitle)
    {
        $this->title = $title;
        $this->subtitle = $subtitle;
    }

    public function render()
    {
        return view('open-graph-image::components.metatags', [
            'title' => $this->title,
            'subtitle' => $this->subtitle,
        ]);
    }
}
