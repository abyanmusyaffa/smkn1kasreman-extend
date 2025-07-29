<?php

namespace App\Livewire\Components;

use Livewire\Component;

class ModalTraining extends Component
{
    public $isOpen = false;
    public $name;
    public $description;
    public $url;

    public function open($description, $name, $url)
    {
        $this->name  = $name ;
        $this->description = $description;
        $this->url = $url;
        $this->isOpen = true;
    }

    public function close()
    {
        $this->isOpen = false;
    }

    protected $listeners = ['open' => 'open'];

    public function render()
    {
        return view('livewire.components.modal-training');
    }
}
