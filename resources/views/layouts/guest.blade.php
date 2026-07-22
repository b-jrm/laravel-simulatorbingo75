<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <!-- <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400&family=Raleway:wght@200&family=Ysabeau+Infant:wght@800&display=swap" rel="stylesheet">

        <style>
            *{
                font-family: 'Open Sans', sans-serif;
                font-family: 'Raleway', sans-serif;
                font-family: 'Ysabeau Infant', sans-serif;
            }
        </style> -->

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @if(isset($styles))
            {{ $styles }}
        @endif

    </head>
    <!-- <body class="antialiased bg-slate-100 relative text-[15px] overflow-hidden overflow-y-auto min-h-screen" x-data="Layout()" x-init="responsive"> -->
    <body class="min-h-screen bg-gradient-to-br from-indigo-950 via-purple-900 to-fuchsia-900 text-white overflow-x-hidden" x-data="Layout()" x-init="responsive">

        @if(isset($header))
            {{ $header }}
        @endif

        <main class="relative z-10 flex min-h-screen flex-col items-center justify-center px-6 py-8 text-center">
            {{ $slot }}
        </main>
        
        @if(isset($footer))
            {{ $footer }}
        @endif

        <!-- <button x-on:click="moveScroll(0, 0)" @scroll.window="scroll.top = window.pageYOffset" class="fixed right-10 bottom-10 rounded-full bg-[#610720] bg-opacity-25 hover:bg-opacity-100 flex justify-center items-center shadow-md p-3 cursor-pointer text-white" x-bind:class="scroll.top ? '' : 'hidden'">
            <svg class="w-[30px] h-[30px]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="M24 0v24H0V0h24ZM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018Zm.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01l-.184-.092Z"/><path fill="currentColor" d="M10.94 7.94a1.5 1.5 0 0 1 2.12 0l5.658 5.656a1.5 1.5 0 1 1-2.122 2.121L12 11.121l-4.596 4.596a1.5 1.5 0 1 1-2.122-2.12l5.657-5.658Z"/></g></svg>
        </button> -->

        @if(isset($scripts))
            {{ $scripts }}
        @endif

    </body>
</html>
