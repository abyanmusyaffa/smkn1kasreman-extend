<?php

namespace App\Livewire\Components;

use Livewire\Component;

class CarouselNews extends Component
{
    public $slug;
    public $createdAt;
    public $title;
    public $content;
    public $photo;

    public function getFirstParagraph()
    {
        if (empty($this->content)) {
            return '';
        }

        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML(mb_convert_encoding($this->content, 'HTML-ENTITIES', 'UTF-8'));
        libxml_clear_errors();

        $paragraphs = $dom->getElementsByTagName('p');
        if ($paragraphs->length > 0) {
            return trim($paragraphs->item(0)->nodeValue);
        }

        return '';
    }

    public function render()
    {
        return view('livewire.components.carousel-news', [
            'summary' => $this->getFirstParagraph(),
        ]);
    }
}
