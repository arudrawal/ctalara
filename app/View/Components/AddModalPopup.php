<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AddModalPopup extends Component
{
    public $modalId;
    public $titleId;
    public $bodyId;
    public $saveId;
    public $title;
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $modalId='compModalPopovers', 
            $titleId='compModalLabel', $bodyId='compModalBody', $saveId='compModalSave')
    {
        $this->modalId = $modalId;
        $this->bodyId = $bodyId;
        $this->titleId = $titleId;
        $this->saveId = $saveId;
        $this->title = $title;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.add-modal-popup');
    }
}
