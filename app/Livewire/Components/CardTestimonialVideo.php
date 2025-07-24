<?php

namespace App\Livewire\Components;

use Livewire\Component;

class CardTestimonialVideo extends Component
{
    public $url;
    public $name;
    public $rating;
    public $position;
    public $company;
    public $passing_year;
    public $photo;

    public function render()
    {
        return view('livewire.components.card-testimonial-video', [
            'video_id' => $this->getYoutubeVideoId($this->url)
        ]);
    }

    private function getYoutubeVideoId(?string $url): ?string
    {
        if (!$url) {
            return null;
        }

        preg_match(
            '/(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=)|youtu\.be\/)([a-zA-Z0-9_-]{11})/',
            $url,
            $matches
        );

        return $matches[1] ?? null;
    }
}
