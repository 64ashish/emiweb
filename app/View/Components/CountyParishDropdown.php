<?php

namespace App\View\Components;

use Illuminate\View\Component;

class CountyParishDropdown extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($filterAttribute, $keywords)
    {
        //
        $this->filterAttribute = $filterAttribute;
        $this->keywords = $keywords;

    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.county-parish-dropdown');
    }
}
