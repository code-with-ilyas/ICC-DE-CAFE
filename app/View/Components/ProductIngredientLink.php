<?php

namespace App\View\Components;

use Illuminate\View\Component;

class ProductIngredientLink extends Component
{
    public $productId;

    /**
     * Create a new component instance.
     */
    public function __construct($productId)
    {
        $this->productId = $productId;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.product-ingredient-link');
    }
}
