{{-- @dd($announcements, $enrollments, $achievements) --}}
<div class="flex w-full flex-col items-center gap-4">
    {{-- Search Input --}}
    <div class="w-full lg:w-1/4 self-end">
        <div class="relative">
            <input type="text" wire:model.live.debounce.300ms="search" placeholder="Cari..." class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                <span class="icon-[mingcute--search-ai-line] text-slate-600"></span>
            </div>
        </div>
    </div>

    {{-- Loading State --}}
    <div wire:loading class="px-4 py-2 bg-blue-100 border border-blue-200 rounded-lg">
        <span class="icon-[mingcute--loading-3-fill] text-blue-800 animate-spin mr-1"></span>
        <p class="text-blue-800 inline">Mencari...</p>
    </div>
    {{-- Loading State --}}

    <div wire:loading.remove class="w-full">
        @if($partners && $partners->count() > 0)
            <div class="grid w-full gap-4 lg:grid-cols-2">
                @foreach($partners as $partner)
                    <livewire:components.card-partner wire:key="{{ $partner->id }}" :logo="$partner->logo" :name="$partner->name" :address="$partner->address" :industry="$partner->industry" />
                @endforeach
            </div>
        @elseif($teachingFactories && $teachingFactories->count() > 0)
            <div class="grid w-full gap-4 lg:grid-cols-4">
                @foreach($teachingFactories as $teachingFactory)
                    <livewire:components.card-teaching-factory wire:key="{{ $teachingFactory->id }}" :logo="$teachingFactory->logo" :name="$teachingFactory->name" :slug="$teachingFactory->slug" />
                @endforeach
            </div>
        @elseif($businessUnits && $businessUnits->count() > 0)
            <div class="grid w-full gap-4 lg:grid-cols-4">
                @foreach($businessUnits as $businessUnit)
                    <livewire:components.card-business-unit wire:key="{{ $businessUnit->id }}" :logo="$businessUnit->logo" :name="$businessUnit->name" :slug="$businessUnit->slug" />
                @endforeach
            </div>
        @elseif($studentEvents && $studentEvents->count() > 0)
            <div class="grid lg:grid-cols-2 xl:grid-cols-3 w-full gap-4 ">
                @foreach($studentEvents as $studentEvent)
                <livewire:components.card-student-event wire:key="{{ $studentEvent->id }}" :id="$studentEvent->id" :name="$studentEvent->name" :photo="$studentEvent->photo" :description="$studentEvent->description" :start_date="$studentEvent->start_date" :end_date="$studentEvent->end_date" :start_time="$studentEvent->start_time" :end_time="$studentEvent->end_time" :location="$studentEvent->location" >
                @endforeach
            </div>
        @elseif($trainings && $trainings->count() > 0)
            <div class="grid lg:grid-cols-4 w-full gap-4 ">
                @foreach($trainings as $training)
                <livewire:components.card-training wire:key="{{ $training->id }}" :id="$training->id" :name="$training->name" :photo="$training->photo" :description="$training->description" :start_date="$training->start_date" :end_date="$training->end_date" :start_time="$training->start_time" :end_time="$training->end_time" :location="$training->location" :url="$training->url" :organizer="$training->organizer" :participants="$training->participants" >
                @endforeach
            </div>
        @elseif($extracurriculars && $extracurriculars->count() > 0)
            <div class="grid w-full lg:grid-cols-4 gap-4">
                @foreach($extracurriculars as $extracurricular)
                <livewire:components.card-extracurricular wire:key="{{ $extracurricular->id }}" :slug="$extracurricular->slug" :logo="$extracurricular->logo" :name="$extracurricular->name" />
                @endforeach
            </div>
        @elseif($testimonials && $testimonials->count() > 0)
            <div class="grid w-full lg:grid-cols-3 gap-4">
                @foreach($testimonials as $testimonial)
                <livewire:components.card-testimonial wire:key="{{ $testimonial->id }}" :photo="$testimonial->alumnis->photo" :name="$testimonial->alumnis->name" :passing_year="$testimonial->alumnis->passing_year" :position="$testimonial->position" :company="$testimonial->company" :content="$testimonial->content" :rating="$testimonial->rating" />
                @endforeach
            </div>
        @elseif($achievements && $achievements->count() > 0)
            <div class="grid w-full gap-2 lg:gap-4 lg:grid-cols-4">
                @foreach($achievements as $achievement)
                    <livewire:components.card-achievement wire:key="{{ $achievement->id }}" :slug="$achievement->slug" :photo="$achievement->photo" :rankings="$achievement->rankings" :title="$achievement->title" :created_at="$achievement->created_at" /> 
                @endforeach
            </div>
        @elseif($announcements && $announcements->count() > 0)
            <div class="grid w-full gap-4 lg:grid-cols-4">
                @foreach($announcements as $announcement)
                    <livewire:components.card-article wire:key="{{ $announcement->id }}" :category="$announcement->category" :slug="$announcement->slug" :photo="$announcement->photo" :created_at="$announcement->created_at" :title="$announcement->title" />
                @endforeach
            </div>
        @elseif($enrollments && $enrollments->count() > 0)
            <div class="grid w-full gap-4 lg:grid-cols-4">
                @foreach($enrollments as $enrollment)
                    <livewire:components.card-article wire:key="{{ $enrollment->id }}" :category="$enrollment->category" :slug="$enrollment->slug" :photo="$enrollment->photo" :created_at="$enrollment->created_at" :title="$enrollment->title" />
                @endforeach
            </div>
        @elseif($news && $news->count() > 0)
            <div class="grid w-full gap-4 lg:grid-cols-4">
                @foreach($news as $item)
                    <livewire:components.card-article wire:key="{{ $item->id }}" :category="$item->category" :slug="$item->slug" :photo="$item->photo" :created_at="$item->created_at" :title="$item->title" />
                @endforeach
            </div>
        @elseif($jobfairs && $jobfairs->count() > 0)
            <div class="grid w-full gap-4 lg:grid-cols-4">
                @foreach($jobfairs as $jobfair)
                    <livewire:components.card-jobfair wire:key="{{ $jobfair->id }}" :slug="$jobfair->slug" :photo="$jobfair->photo" :deadline="$jobfair->deadline" :title="$jobfair->title" />
                @endforeach
            </div>
        @else
            {{-- No Results Found --}}
            @if($search)
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 12h6m-6 0a4 4 0 015.656-5.656M9 12H3m6 0v6m0-6V6"></path>
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada hasil</h3>
                    <p class="mt-1 text-sm text-gray-500">Tidak ditemukan hasil untuk pencarian "{{ $search }}"</p>
                </div>
            @endif
        @endif
    </div>

    @if($testimonials && $testimonials->count() > 0)
        {{ $testimonials->links(data: ['scrollTo' => false]) }}
    @elseif($studentEvents && $studentEvents->count() > 0)
        {{ $studentEvents->links(data: ['scrollTo' => false]) }}
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