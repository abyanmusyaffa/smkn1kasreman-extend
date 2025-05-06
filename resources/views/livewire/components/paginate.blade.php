{{-- @dd($achievements ) --}}
<div class="flex w-full flex-col gap-6">
    @if($partners && $partners->count() > 0)
        <div class="grid w-full gap-4 lg:grid-cols-2">
            @foreach($partners as $partner)
                <livewire:components.card-partner wire:key="{{ $partner->id }}" :logo="$partner->logo" :name="$partner->name" :address="$partner->address" :industry="$partner->industry" />
            @endforeach
        </div>
    @elseif($testimonials && $testimonials->count() > 0)
        <div class="grid w-full lg:grid-cols-3 gap-4">
            @foreach($testimonials as $testimonial)
            {{-- @dd($testimonial->alumnis) --}}
            <livewire:components.card-testimonial wire:key="{{ $testimonial->id }}" :photo="$testimonial->alumnis->photo" :name="$testimonial->alumnis->name" :passing_year="$testimonial->alumnis->passing_year" :position="$testimonial->position" :company="$testimonial->company" :content="$testimonial->content" :rating="$testimonial->rating" />
            @endforeach
        </div>
    @elseif($achievements && $achievements->count() > 0)
        <div class="grid w-full gap-4 lg:grid-cols-4">
            @foreach($achievements as $achievement)
                <livewire:components.card-achievement wire:key="{{ $achievement->id }}" :slug="$achievement->slug" :photo="$achievement->photo" :rankings="$achievement->rankings" :title="$achievement->title" :createdAt="$achievement->created_at" /> 
            @endforeach
        </div>
    @elseif($announcements && $announcements->count() > 0)
        <div class="grid w-full gap-4 lg:grid-cols-4">
            @foreach($announcements as $announcement)
                <livewire:components.card-article wire:key="{{ $announcement->id }}" :category="$announcement->category" :slug="$announcement->slug" :photo="$announcement->photo" :createdAt="$announcement->created_at" :title="$announcement->title" />
            @endforeach
        </div>
    @elseif($enrollments && $enrollments->count() > 0)
        <div class="grid w-full gap-4 lg:grid-cols-4">
            @foreach($enrollments as $enrollment)
                <livewire:components.card-article wire:key="{{ $enrollment->id }}" :category="$enrollment->category" :slug="$enrollment->slug" :photo="$enrollment->photo" :createdAt="$enrollment->created_at" :title="$enrollment->title" />
            @endforeach
        </div>
    @elseif($news && $news->count() > 0)
        <div class="grid w-full gap-4 lg:grid-cols-4">
            @foreach($news as $item)
                <livewire:components.card-article wire:key="{{ $item->id }}" :category="$item->category" :slug="$item->slug" :photo="$item->photo" :createdAt="$item->created_at" :title="$item->title" />
            @endforeach
        </div>
    @elseif($jobfairs && $jobfairs->count() > 0)
        <div class="grid w-full gap-4 lg:grid-cols-4">
            @foreach($jobfairs as $jobfair)
                <livewire:components.card-jobfair wire:key="{{ $jobfair->id }}" :slug="$jobfair->slug" :photo="$jobfair->photo" :deadline="$jobfair->deadline" :title="$jobfair->title" />
            @endforeach
        </div>
    @endif

    @if($partners && $partners->count() > 0)
        {{ $partners->links(data: ['scrollTo' => false]) }}
    @elseif($testimonials && $testimonials->count() > 0)
        {{ $testimonials->links(data: ['scrollTo' => false]) }}
    @elseif($achievements && $achievements->count() > 0)
        {{ $achievements->links(data: ['scrollTo' => false]) }}
    @elseif($announcements && $announcements->count() > 0)
        {{ $announcements->links(data: ['scrollTo' => false]) }}
    @elseif($enrollments && $enrollments->count() > 0)
        {{ $enrollments->links(data: ['scrollTo' => false]) }}
    @elseif($news && $news->count() > 0)
        {{ $news->links(data: ['scrollTo' => false]) }}
    @elseif($jobfairs && $jobfairs->count() > 0)
        {{ $jobfairs->links(data: ['scrollTo' => false]) }}
    @endif
</div>