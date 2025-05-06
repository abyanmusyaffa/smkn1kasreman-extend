<div class="w-full lg:min-h-[calc(100svh-376px)] min-h-[calc(100svh-512px)] flex flex-col gap-9 lg:gap-12 px-4 pt-20 pb-9 lg:px-16 2xl:px-36 lg:pt-[120px] lg:pb-12 bg-slate-100">
    <!-- alumni -->
    <article class="flex w-full flex-col gap-4 lg:gap-6 items-center">
        <livewire:components.title-left text="Download" span="Area" />

        @if($download->count() > 0)
        <div class="flex bg-white rounded-2xl w-full p-4 lg:p-6">
            <div class="prose w-full max-w-none prose-figure:w-36 lg:prose-figure:w-56">
               {!! $download->content !!}
            </div>
        </div>
        @endif
    </article>
    <!-- alumni -->
</div>
