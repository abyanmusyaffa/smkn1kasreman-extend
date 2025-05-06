<?php

namespace App\Livewire\Components;

use Livewire\Component;

class CardMajor extends Component
{
    public $logo;
    public $photo;
    public $alias;
    public $expertise_concentration;
    public $description;
    public $studyGroup;
    public $studyPeriod;
    public $totalStudents;
    public $index;

    public function getFirstParagraph()
    {
        if (empty($this->description)) {
            return '';
        }

        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML(mb_convert_encoding($this->description, 'HTML-ENTITIES', 'UTF-8'));
        libxml_clear_errors();

        $paragraphs = $dom->getElementsByTagName('p');
        if ($paragraphs->length > 0) {
            return trim($paragraphs->item(0)->nodeValue);
        }

        return '';
    }
    
    public function render()
    {
        return view('livewire.components.card-major', [
            'summary' => $this->getFirstParagraph(),
        ]);
    }
}
