<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
 
        <meta name="description" content="{{ $description }}">
        <meta name="keywords" content="SMKN 1 Kasreman, Skanka, Skanka Ngawi, SMK Ngawi, Kasreman, SMK Negeri 1 Kasreman, SMK Blue, SMK Biru, TKJ, Akuntansi, Kuliner, Busana, Cangakan, SMK, Sekolah Menengah Kejuruan, Jurusan, SPMB Ngawi">
        <meta name="author" content="Abyan Aufa Alif Musyaffa">
        <meta name="application-name" content="{{ config('app.name') }}">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" href="/storage/{{ $logo }}" type="image/png">
 
        <title>{{ $title }} | SMKN {{ $name }}</title>
 
        <style>
            [x-cloak] {
                display: none !important;
            }
        </style>
        <link rel="stylesheet" href="/css/custom.css">
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        @filamentStyles
        @vite('resources/css/app.css')
    </head>
 
    <body class="antialiased font-poppins">
        {{-- <livewire:components.loading-overlay/> --}}

        <livewire:templates.header />
        <main>
            {{ $slot }}
        </main>
        <livewire:templates.footer />

        {{-- <script src="/js/script.js"></script> --}}
        <script>
            AOS.init();
        </script>
        @filamentScripts
        @vite('resources/js/app.js')
    </body>
</html>