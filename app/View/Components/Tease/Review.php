<?php

namespace App\View\Components\Tease;

use Illuminate\View\Component;

class Review extends Component
{
    /** @var \App\Models\Review $review */
    public $review;

    public function __construct(\App\Models\Review $review)
    {
        $this->review = $review;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.tease.review');
    }
}
