<div class="w-full lg:min-h-[calc(100svh-376px)] min-h-[calc(100svh-512px)] flex flex-col gap-9 lg:gap-12 px-4 pt-20 pb-9 lg:px-16 2xl:px-36 lg:pt-[120px] lg:pb-12 bg-slate-100">
    <!-- major -->
    <article class="flex w-full flex-col gap-4 lg:gap-6 items-center">
        <livewire:components.title-left text="Program" span="Keahlian" />
      <div class="flex flex-col gap-4 lg:gap-6 w-full">

        @foreach($majors as $index => $major)
        <livewire:components.card-major wire:key="{{ $major->id }}" :logo="$major->logo" :photo="$major->photo" :alias="$major->alias" :expertise_concentration="$major->expertise_concentration" :description="$major->description" :studyGroup="$major->study_group" :studyPeriod="$major->study_period" :totalStudents="$major->total_students" :index="$index" />
        @endforeach
      </div>
    </article>

    <livewire:components.modal-major />
    <!-- major -->
  </div>