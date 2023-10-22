<x-guest-layout>

    <x-slot name="styles">
        <style>
            .bg-content{
                /* background: rgb(76,5,16);
                background: linear-gradient(90deg, rgba(76,5,16,1) 0%, rgba(255,255,255,0) 35%, rgba(76,5,16,1) 100%); */
                background: linear-gradient(45deg, #4c0519 50%, rgba(0, 0, 0, 0) 0%);
            }

            .bg-btn-active-bingo{
                background-image: url("{{ asset('storage/assets/img/elements/bingo_activo.png') }}");
                background-repeat: no-repeat;
                background-position: center center;
                background-size: cover;
            }
        </style>
    </x-slot>

    <x-slot name="header">
        <header class="w-screen min-h-[70px] border-b flex items-center justify-between text-[15px] relative">
            
            <a href="{{ route('home') }}" class="">
                <img src="{{ asset('storage/assets/img/logo.png') }}" class="max-w-[60px] m-4"></img>
            </a>
            
            <span class="block text-[#4c0519] cursor-pointer border p-2 transition-all m-4 hover:bg-gray-200" x-on:click="aside.show = !aside.show">
                <template x-if="aside.show">
                    <svg class="w-[30px] h-[30px]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M17.414 6.586a2 2 0 0 0-2.828 0L12 9.172L9.414 6.586a2 2 0 1 0-2.828 2.828L9.171 12l-2.585 2.586a2 2 0 1 0 2.828 2.828L12 14.828l2.586 2.586c.39.391.902.586 1.414.586s1.024-.195 1.414-.586a2 2 0 0 0 0-2.828L14.829 12l2.585-2.586a2 2 0 0 0 0-2.828z"/></svg>
                </template>
                <template x-if="!aside.show">
                    <svg class="w-[30px] h-[30px]" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20"><path fill="currentColor" d="M8 17h7.5a1.5 1.5 0 0 0 1.5-1.5v-1a1.5 1.5 0 0 0-1.5-1.5H8v4Zm0-5h7.5a1.5 1.5 0 0 0 1.5-1.5v-1A1.5 1.5 0 0 0 15.5 8H8v4ZM7 8v4H4.5A1.5 1.5 0 0 1 3 10.5v-1A1.5 1.5 0 0 1 4.5 8H7Zm1-1h7.5A1.5 1.5 0 0 0 17 5.5v-1A1.5 1.5 0 0 0 15.5 3H8v4ZM7 3v4H4.5A1.5 1.5 0 0 1 3 5.5v-1A1.5 1.5 0 0 1 4.5 3H7Zm0 10v4H4.5A1.5 1.5 0 0 1 3 15.5v-1A1.5 1.5 0 0 1 4.5 13H7Z"/></svg>
                </template>
            </span>
        
            <aside class="bg-[#4c0519] md:w-[250px] min-h-screen flex flex-col absolute top-[88px] transition-all p-4 border-l" x-bind:class="aside.show ? 'right-0' : '-right-[250px]'" x-on:click.away="aside.show = false">

                <a href="{{ route('simulator') }}" class="p-0 m-0 mb-6">

                    <div class="flex flex-row flex-nowrap items-center justify-between w-full border rounded-full bg-[#610720] overflow-hidden text-white hover:text-black hover:bg-white transition-all">

                        <div class="text-black bg-white p-4">
                            <svg class="w-[25px] h-[25px]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M10 20H8V4h2v2h2v3h2v2h2v2h-2v2h-2v3h-2v2z"/></svg>
                        </div>

                        <div class="w-full h-full p-4">
                            <p class="">{{ __('Simulator') }}</p>
                        </div>
                        
                    </div>
                   
                </a>

                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="ml-4 font-semibold text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="p-0 m-0 mb-6">

                            <div class="flex flex-row flex-nowrap items-center justify-between w-full border rounded-full bg-[#610720] overflow-hidden text-white hover:text-black hover:bg-white transition-all">

                                <div class="text-black bg-white p-4">
                                    <svg class="w-[25px] h-[25px]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M10 20H8V4h2v2h2v3h2v2h2v2h-2v2h-2v3h-2v2z"/></svg>
                                </div>

                                <div class="w-full h-full p-4">
                                    <p class="">{{ __('Login') }}</p>
                                </div>
                                
                            </div>

                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="p-0 m-0 mb-6">

                                <div class="flex flex-row flex-nowrap items-center justify-between w-full border rounded-full bg-[#610720] overflow-hidden text-white hover:text-black hover:bg-white transition-all">

                                    <div class="text-black bg-white p-4">
                                        <svg class="w-[25px] h-[25px]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M10 20H8V4h2v2h2v3h2v2h2v2h-2v2h-2v3h-2v2z"/></svg>
                                    </div>

                                    <div class="w-full h-full p-4">
                                        <p class="">{{ __('Register') }}</p>
                                    </div>
                                    
                                </div>

                            </a>
                        @endif
                    @endauth
                @endif


                <!-- <a href="{{ route('support') }}" class="p-0 m-0 mb-6">
                    <div class="flex flex-row flex-nowrap items-center justify-between w-full border rounded-full bg-[#610720] overflow-hidden text-white hover:text-black hover:bg-white transition-all">
                        <div class="text-black bg-white p-4">
                            <svg class="w-[25px] h-[25px]" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="m12 22l-.25-3h-.25q-3.55 0-6.025-2.475T3 10.5q0-3.55 2.475-6.025T11.5 2q1.775 0 3.313.662t2.7 1.825q1.162 1.163 1.824 2.7T20 10.5q0 1.875-.613 3.6t-1.675 3.2q-1.062 1.475-2.525 2.675T12 22Zm-.525-6.025q.425 0 .725-.3t.3-.725q0-.425-.3-.725t-.725-.3q-.425 0-.725.3t-.3.725q0 .425.3.725t.725.3ZM10.75 12.8h1.5q0-.75.15-1.05t.95-1.1q.45-.45.75-.975t.3-1.125q0-1.275-.863-1.913T11.5 6q-1.1 0-1.85.613T8.6 8.1l1.4.55q.125-.425.475-.838T11.5 7.4q.675 0 1.012.375t.338.825q0 .425-.25.763t-.6.687q-.875.75-1.063 1.188T10.75 12.8Z"/></svg>
                        </div>
                        <div class="w-full h-full p-4">
                            <p class="">{{ __('Question') }}</p>
                        </div>
                    </div>
                </a> -->

            </aside>
                
        </header>
    </x-slot>

    <div class="bg-content h-[100vh] flex justify-center items-center">

        <a href="{{ route('simulator') }}" class="flex flex-row flex-nowrap border-4 border-white rounded-full w-[250px] h-[90px] bg-[#4c0519] p-0 m-0 text-[50px] text-center overflow-hidden text-white transition-all hover:bg-[#610720] active:bg-[#610720]">

            <div class="flex justify-center items-center bg-[#610720] p-6 rounded-full">
                <svg form="play" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="M24 0v24H0V0h24ZM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018Zm.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01l-.184-.092Z"/><path fill="currentColor" d="M5.669 4.76a1.469 1.469 0 0 1 2.04-1.177c1.062.454 3.442 1.533 6.462 3.276c3.021 1.744 5.146 3.267 6.069 3.958c.788.591.79 1.763.001 2.356c-.914.687-3.013 2.19-6.07 3.956c-3.06 1.766-5.412 2.832-6.464 3.28c-.906.387-1.92-.2-2.038-1.177c-.138-1.142-.396-3.735-.396-7.237c0-3.5.257-6.092.396-7.235Z"/></g></svg>
            </div>
            <p class="pl-6">{{ __('Jugar') }}</p>
            
        </a>

    </div>

    <x-slot name="footer">
        <footer class="w-full min-h-[300px] ">
            <div class="grid grid-cols-1 md:grid-cols-1 p-12 gap-4">
                <div class="min-h-[300px] border-l my-3 p-6">

                    <form class="flex flex-col border border-[#610720] text-black text-[15px] rounded-md" x-on:submit.prevent="support">

                        <div class="w-full bg-[#610720] rounded-t-md p-3 text-white">
                            <h3 class="uppercase" for="email">
                                {{ __('Ask me') }}:
                                <span class="cursor-pointer tooltip tooltip-right tooltip-top md:tooltip-warning lowercase" data-tip="{{ __('Leave us your question and your email to answer you') }}">
                                    <svg class="inline w-[20px] h-[20px]" name="question" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><g fill="none"><path d="M24 0v24H0V0h24ZM12.593 23.258l-.011.002l-.071.035l-.02.004l-.014-.004l-.071-.035c-.01-.004-.019-.001-.024.005l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.017-.018Zm.265-.113l-.013.002l-.185.093l-.01.01l-.003.011l.018.43l.005.012l.008.007l.201.093c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.004-.011l.017-.43l-.003-.012l-.01-.01l-.184-.092Z"/><path fill="currentColor" d="M12 2c5.523 0 10 4.477 10 10s-4.477 10-10 10S2 17.523 2 12S6.477 2 12 2Zm0 14a1 1 0 1 0 0 2a1 1 0 0 0 0-2Zm0-9.5a3.625 3.625 0 0 0-3.625 3.625a1 1 0 1 0 2 0a1.625 1.625 0 1 1 2.23 1.51c-.676.27-1.605.962-1.605 2.115V14a1 1 0 1 0 2 0c0-.244.05-.366.261-.47l.087-.04A3.626 3.626 0 0 0 12 6.5Z"/></g></svg>
                                </span>
                            </h3>
                        </div>

                        <div class="w-full px-6 py-3">
                            <label class="" for="email">
                                {{ __('Email') }}:
                            </label>
                            <input type="email" id="email" name="email" class="w-full bg-white border rounded-sm px-3" placeholder="{{ __('Email') }}" required/>
                        </div>
                        <div class="w-full px-6 py-3">
                            <label class="" for="message">
                                {{ __('Message') }}:
                            </label>
                            <textarea type="text" id="message" name="message" class="w-full bg-white border rounded-sm px-3 focus:outline-1 focus:ring-1 focus:ring-[#610720] focus:outline-[#610720] focus:border-[#610720]" rows="3" placeholder="{{ __('Message') }}" required></textarea>
                        </div>

                        <div class="w-full p-6 pt-0">
                            <button type="submit" class="block text-center text-white border rounded-md leading-10 px-6 bg-[#610720]">
                                {{ __('Send') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </footer>
    </x-slot>

    <x-slot name="scripts">
        <script>
            const Header = () => {
                return {
                    
                }
            }
        </script>
    </x-slot>

</x-guest-layout>
<!-- <img src="{{ asset('storage/assets/img/logo.png') }}" class="w-auto h-[40px]"></img> -->