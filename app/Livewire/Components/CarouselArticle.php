<?php

namespace App\Livewire\Components;

use Livewire\Component;

class CarouselArticle extends Component
{
    public $photo;
    public $rankings;
    public $content;
    public $title;
    public $slug;
    public $category;
    public $created_at;

    public function getFirstParagraph($content)
    {
        if (empty($content)) {
            return '';
        }

        $dom = new \DOMDocument();
        libxml_use_internal_errors(true);
        $dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'));
        libxml_clear_errors();

        $paragraphs = $dom->getElementsByTagName('p');
        if ($paragraphs->length > 0) {
            return trim($paragraphs->item(0)->nodeValue);
        }

        return '';
    }

    public function render()
    {
        return view('livewire.components.carousel-article', [
            'summary' => $this->getFirstParagraph($this->content)
        ]);
    }
}
