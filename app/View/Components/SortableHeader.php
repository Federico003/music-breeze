<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class SortableHeader extends Component
{
    public string $column;
    public string $label;
    public string $field;
    public ?string $currentSort;
    public ?string $currentDirection;

   public function __construct(
    string $field,
    string $label = '',
    ?string $currentSort = null,
    ?string $currentDirection = null
) {
    $this->field = $field;
    $this->label = $label;
    $this->currentSort = $currentSort;
    $this->currentDirection = $currentDirection;
}




    public function render()
    {
        return view('components.sortable-header');
    }
}
