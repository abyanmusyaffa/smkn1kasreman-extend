<div class="w-full lg:min-h-[calc(100svh-376px)] min-h-[calc(100svh-512px)] flex flex-col gap-9 lg:gap-12 px-4 pt-20 pb-9 lg:px-16 2xl:px-36 lg:pt-[120px] lg:pb-12 bg-slate-100">
    <!-- extra -->
    <article class="flex w-full flex-col gap-4 lg:gap-6 items-center">
        <livewire:components.title-left text="Ekstrakurikuler" />
      <div class="flex flex-col gap-4 lg:gap-6 w-full">
          <div class="grid w-full lg:grid-cols-4 gap-4">
            @foreach($extracurriculars as $extracurricular)
                <livewire:components.card-extracurricular wire:key="{{ $extracurricular->id }}" :url="$extracurricular->url" :logo="$extracurricular->logo" :name="$extracurricular->name" />
            @endforeach
          </div>
      </div>
    </article>
    <!-- extra -->
  </div>