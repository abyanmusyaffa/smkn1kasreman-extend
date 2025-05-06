<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Maintenance</title>
    <link rel="stylesheet" href="/css/custom.css">
    @vite('resources/css/app.css')
</head>
<body>
    <div class="min-h-svh fixed inset-0 flex flex-col bg-blue-600 z-50">
        <div class="flex flex-col size-full items-center justify-center gap-4">
            <span class="icon-[mingcute--loading-3-fill] text-slate-50 animate-spin text-6xl"></span>
            <p class="text-blue-300 lg:text-xl"><span class="font-bold text-blue-200">website</span> sedang dalam perbaikan</p>
        </div>
        <div class="grid place-items-center w-full h-8 lg:h-12 bg-blue-700">
            <p class="text-slate-50 text-2xs lg:text-lg">© 2024 SMK N 1 Kasreman ft Abyan Aufa Alif Musyaffa</p>
        </div>
    </div>
    @vite('resources/js/app.js')
</body>
</html>