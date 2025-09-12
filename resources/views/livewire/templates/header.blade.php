<header>
  <nav class="w-full flex justify-between bg-gradient-to-r from-blue-500 to-blue-700 h-16 lg:h-24 px-4 lg:px-16 2xl:px-36 items-center fixed z-30">
    <!-- logo -->
    <a href="/" wire:navigate class="flex gap-2 2xl:gap-4 items-center">
      <img src="/storage/{{ $school->logo }}" class="w-9 lg:w-12 2xl:w-16" alt="logo-skanka" />
      <p class="font-medium text-slate-50 lg:text-lg 2xl:text-2xl">SMKN {{ $school->name }}</p>
    </a>
    <!-- logo -->

    <!-- menu web -->
    <livewire:templates.menu-web :title="$title" :school="$school" :osis_slug="$osis_slug" :osis_name="$osis_name" :web_links="$web_links" :teaching_factories="$teaching_factories" :business_units="$business_units" :school_departments="$school_departments" :school_programs="$school_programs" />
    <!-- menu web -->

    <!-- btn menu mobile-->
    <input type="checkbox" class="peer hidden" id="dropdown-menu"/>
    <label for="dropdown-menu" class="lg:hidden hidden peer-checked:block cursor-pointer">
      <span class="icon-[mdi--close] text-3xl text-slate-50"></span>
    </label>
    <label for="dropdown-menu" class="lg:hidden peer-checked:hidden cursor-pointer">
      <span class="icon-[mdi--hamburger-menu] text-3xl text-slate-50"></span>
    </label>
    <!-- btn menu mobile-->

    <!-- menu mobile -->
    <livewire:templates.menu-mobile :title="$title" :school="$school" :osis_slug="$osis_slug" :osis_name="$osis_name" :web_links="$web_links" :teaching_factories="$teaching_factories" :business_units="$business_units" :school_departments="$school_departments" :school_programs="$school_programs" />
    <!-- menu mobile -->
  </nav>
</header>