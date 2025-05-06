<?php

namespace App\Livewire\Components;

use Livewire\Component;

class ModalMajor extends Component
{
    public $isOpen = false;
    public $logo;
    public $alias;
    public $expertise_concentration;
    public $description;

    public function open($description, $logo, $alias, $expertise_concentration)
    {
        $this->logo = $logo;
        $this->alias = $alias;
        $this->expertise_concentration  = $expertise_concentration ;
        $this->description = $description;
        $this->isOpen = true;
    }

    public function close()
    {
        $this->isOpen = false;
    }

    protected $listeners = ['open' => 'open'];

    public function render()
    {
        return view('livewire.components.modal-major');
    }
}
