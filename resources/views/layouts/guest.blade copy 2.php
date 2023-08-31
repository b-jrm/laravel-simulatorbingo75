<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
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
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        @if(isset($styles))
            {{ $styles }}
        @endif

    </head>
    <body class="antialiased bg-slate-200 relative text-[13px] overflow-x-hidden" x-data="Layout()" x-init="responsive">

        <header class="w-full h-auto flex flex-row flex-nowrap justify-between bg-white p-6">

            <a class="" href="{{ route('home') }}">
                <img src="{{ asset('storage/assets/img/logo.png') }}" class="w-auto h-[40px]"></img>
            </a>

            <nav class="relative" x-on:click.away="account.show = false">

                <div class="flex justify-end items-center cursor-pointer p-1 px-2 rounded-full border hover:bg-gray-200 hover:shadow-2xl transition-all" x-on:click="account.show = !account.show">
                    <p class="block text-[13px]">Account&nbsp;</p>
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M9.745 21.745C5.308 20.722 2 16.747 2 12C2 6.477 6.477 2 12 2s10 4.477 10 10c0 4.747-3.308 8.722-7.745 9.745L12 24l-2.255-2.255Zm-2.733-3.488a7.953 7.953 0 0 0 3.182 1.539l.56.129L12 21.172l1.247-1.247l.56-.13a7.955 7.955 0 0 0 3.36-1.686A6.979 6.979 0 0 0 12.16 16c-2.036 0-3.87.87-5.148 2.257ZM5.616 16.82A8.975 8.975 0 0 1 12.16 14a8.972 8.972 0 0 1 6.362 2.634a8 8 0 1 0-12.906.187ZM12 13a4 4 0 1 1 0-8a4 4 0 0 1 0 8Zm0-2a2 2 0 1 0 0-4a2 2 0 0 0 0 4Z"/></svg>
                </div>

                <ul class="flex flex-col w-auto min-w-[150px] bg-white rounded-sm z-40 absolute top-20 left-1/2 transform -translate-x-1/2 md:-left-1/2 md:-translate-x-0" x-show="account.show">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">{{ __('Dashboard') }}</a>
                        @else
                            <li class="p-0 m-0 hover:bg-stone-100">
                                <a href="{{ route('login') }}" class="flex flex-row justify-between items-center w-full cursor-pointer p-2">
                                    {{ __('Log in') }}&nbsp;
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M11 10v2H9v2H7v-2H5.8c-.4 1.2-1.5 2-2.8 2c-1.7 0-3-1.3-3-3s1.3-3 3-3c1.3 0 2.4.8 2.8 2H11m-8 0c-.6 0-1 .4-1 1s.4 1 1 1s1-.4 1-1s-.4-1-1-1m13 4c2.7 0 8 1.3 8 4v2H8v-2c0-2.7 5.3-4 8-4m0-2c-2.2 0-4-1.8-4-4s1.8-4 4-4s4 1.8 4 4s-1.8 4-4 4Z"/></svg>
                                </a>
                            </li>

                            @if (Route::has('register'))
                                <li class="p-0 m-0 hover:bg-stone-100">
                                    <a href="{{ route('register') }}" class="flex flex-row justify-between items-center w-full cursor-pointer p-2">
                                        {{ __('Register') }}&nbsp;
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M15 14c-2.67 0-8 1.33-8 4v2h16v-2c0-2.67-5.33-4-8-4m-9-4V7H4v3H1v2h3v3h2v-3h3v-2m6 2a4 4 0 0 0 4-4a4 4 0 0 0-4-4a4 4 0 0 0-4 4a4 4 0 0 0 4 4Z"/></svg>
                                    </a>
                                </li>
                            @endif
                        @endauth
                    @endif

                    <!-- <li class="p-0 m-0 hover:bg-stone-200 border-t">
                        <a href="{{ route('policies') }}" class="flex flex-row justify-center items-center w-full cursor-pointer p-1">
                            {{ __('Policies/Regulations') }}&nbsp;
                        </a>
                    </li>

                    <li class="p-0 m-0 hover:bg-stone-200">
                        <a href="{{ route('support') }}" class="flex flex-row justify-center items-center w-full cursor-pointer p-1">
                            {{ __('PQRs') }}&nbsp;
                        </a>
                    </li> -->

                </ul>
                

            </nav>

            <div class="cursor-pointer p-1 rounded-full border hover:bg-gray-200 hover:shadow-2xl md:hidden" x-on:click="aside.show = !aside.show" x-on:click.away="aside.show = false">
                <svg class="w-[30px] h-[30px]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="currentColor"><path d="M8 6.983a1 1 0 1 0 0 2h8a1 1 0 1 0 0-2H8ZM7 12a1 1 0 0 1 1-1h8a1 1 0 1 1 0 2H8a1 1 0 0 1-1-1Zm1 3.017a1 1 0 1 0 0 2h8a1 1 0 1 0 0-2H8Z"/><path fill-rule="evenodd" d="M22 12c0 5.523-4.477 10-10 10S2 17.523 2 12S6.477 2 12 2s10 4.477 10 10Zm-2 0a8 8 0 1 1-16 0a8 8 0 0 1 16 0Z" clip-rule="evenodd"/></g></svg>
            </div>

           
        </header>

        <section class="relative w-full flex flex-row">

            <main class="w-full h-screen p-6 m-3 mb-6 flex justify-center items-center bg-white shadow-xl rounded-md z-30 overflow-y-auto">
                {{ $slot }}
            </main>

            <aside class="flex w-auto my-3 absolute md:relative transition bg-rose-950 rounded-tl-md rounded-bl-md ease-in-out delay-150 duration-300 text-white font-bold z-40" x-bind:class="aside.show ? 'right-0' : '-right-60'">
                <ul class="w-auto flex flex-col m-3">
                    <li class="p-0 m-0">
                        <a href="{{ route('simulator') }}" class="flex flex-row justify-start items-center cursor-pointer p-2">
                            <div class="border p-1 rounded-md tooltip tooltip-left tooltip-warning" data-tip="{{ __('Simulator') }}">
                                <svg class="w-[25px] h-[25px]" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48"><mask id="ipTGameEmoji0"><path fill="#555" stroke="#fff" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M38 30H10a6 6 0 0 0 0 12h28a6 6 0 0 0 0-12Zm-2-8a8 8 0 1 0 0-16a8 8 0 0 0 0 16ZM4 14l9-9l9 9l-9 9l-9-9Z"/></mask><path fill="currentColor" d="M0 0h48v48H0z" mask="url(#ipTGameEmoji0)"/></svg>
                            </div>
                            <p class="md:hidden">&nbsp;&nbsp;{{ __('Simulator') }}</p>
                        </a>
                    </li>
                    <li class="p-0 m-0">
                        <a href="{{ route('support') }}" class="flex flex-row justify-start items-center cursor-pointer p-2">
                            <div class="border p-1 rounded-md tooltip tooltip-left tooltip-warning" data-tip="Support">
                                <svg class="w-[25px] h-[25px]" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48"><path fill="currentColor" fill-rule="evenodd" d="M6 20.5C6 12.492 12.492 6 20.5 6h7C35.508 6 42 12.492 42 20.5S35.508 35 27.5 35h-.7v7S6 38.5 6 20.5Zm21.691-8.018c1.03.684 1.807 1.793 1.807 3.28c0 1.578-.637 2.738-1.668 3.448a4.524 4.524 0 0 1-1.33.614v1.532a1.5 1.5 0 1 1-3 0v-2.797a1.5 1.5 0 0 1 1.4-1.497c.554-.037.974-.147 1.228-.322a.699.699 0 0 0 .24-.272c.06-.12.13-.334.13-.707c0-.313-.123-.552-.468-.782c-.392-.26-1.022-.452-1.779-.476c-.748-.024-1.475.122-2.01.381c-.536.26-.732.552-.788.767a1.5 1.5 0 1 1-2.905-.746c.344-1.341 1.348-2.217 2.385-2.72c1.04-.505 2.263-.718 3.414-.681c1.142.036 2.362.324 3.344.978ZM25 29a2 2 0 1 0 0-4a2 2 0 0 0 0 4Z" clip-rule="evenodd"/></svg>
                            </div>
                            <p class="md:hidden">&nbsp;&nbsp;{{ __('Support') }}</p>
                        </a>
                    </li>
                </ul>
            </aside>

        </section>
        
        <footer class="w-full min-h-[300px] border-t">
            Footer
        </footer>

        <script>

            const Layout = () => {
                return {
                    account: {
                        show: false,
                    },
                    aside: {
                        show: false,
                    },
                    options: [
                        { title: "LogIn", url: "{{ route('login') }}" },
                        { title: "SignIn", url: "{{ route('register') }}" },
                    ],
                    responsive(){
                        var width = screen.width;
                        console.log(width);
                        if( width >= 765 )
                            this.aside.show = true;
                    }
                }
            }

        </script>

        @if(isset($scripts))
            {{ $scripts }}
        @endif

    </body>
</html>
