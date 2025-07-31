<?php

namespace App\Livewire;

use App\Models\Article;
use Livewire\Component;
use App\Models\Achievement;
use App\Models\Jobfair;
use Livewire\Attributes\Title;

class ArticleDetail extends Component
{
    public $articleDetail;
    
    public function mount($slug)
    {
        $article = Article::where('slug', $slug)->first();
        $achievement = Achievement::where('slug', $slug)->first();
        $jobfair = Jobfair::where('slug', $slug)->first();
        
        if($article) {
            $this->articleDetail = $article;
        } elseif($achievement) {
            $this->articleDetail = $achievement;
        } elseif($jobfair) {
            $this->articleDetail = $jobfair;
        } else {
            abort(404);
        }
    }
    
    public function render()
    {
        return view('livewire.article-detail', [
            'articles' => $this->articleDetail->category ? Article::where('slug', '!=', $this->articleDetail->slug)->where('is_published', true)->where('category', $this->articleDetail->category)->take(4)->latest()->get() : [] ,
            'achievements' => $this->articleDetail->rankings ? Achievement::where('slug', '!=', $this->articleDetail->slug)->where('is_published', true)->take(4)->latest()->get() : [] ,
            'jobfairs' => $this->articleDetail->deadline ? Jobfair::where('slug', '!=', $this->articleDetail->slug)->where('is_published', true)->take(4)->latest()->get() : [] ,
        ])->title($this->articleDetail->title);
    }
}
