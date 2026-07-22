<x-guest-layout>

    <div x-data="Simulator" x-init="start(); setTimeout(() => { moveScroll(0, 999999, '#sequences') }, 1000);" 
    class="w-full mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:py-10 relative"
    >
    <!-- class="w-full rounded-lg overflow-hidden flex flex-col relative" -->

        <template x-if="pause">
            <div class="flex flex-col items-center justify-center p-12 w-full h-full absolute z-20 top-0 bottom-0 bg-gray-600 bg-opacity-50">
                <h4 class="text-white text-[30px]">{{ __('Paused') }}</h4>
                <hr><br>
                <span x-on:click="keep" class="cursor-pointer tooltip tooltip-bottom tooltip-warning border border-yellow-600 bg-yellow-600 rounded-md p-6 flex flex-col items-center" data-tip="{{ __('Continue') }}">
                    <svg name="continue" title="" class="w-[30px] w-[30px] text-white" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"><path fill="currentColor" d="M10 28a1 1 0 0 1-1-1V5a1 1 0 0 1 1.501-.865l19 11a1 1 0 0 1 0 1.73l-19 11A.998.998 0 0 1 10 28zM4 4h2v24H4z"/></svg>
                    <h4 class="text-white text-[30px]">{{ __('Continue') }}</h4>
                </span>
                
            </div>
        </template>

        <template x-if="sequence.length == 0">
            <audio id="start" x-bind:src="'{{ asset('storage/sounds') }}/'+setting.sound.start.audio" autoplay></audio>
        </template>

        <template x-if="setting.sound.serie.audio !== ''">
            <audio id="serie" x-bind:src="'{{ asset('storage/sounds') }}/'+setting.sound.serie.audio+'.mp3'" autoplay></audio>
        </template>

        <template x-if="setting.sound.bolillero.audio !== ''">
            <audio id="bolillero" x-bind:src="'{{ asset('storage/sounds') }}/'+setting.sound.bolillero.audio" class="hidden" autoplay loop controls x-bind:volume="setting.sound.bolillero.volume"></audio>
        </template>

        <template x-if="setting.sound.shot.audio !== ''">
            <audio id="shot" x-bind:src="'{{ asset('storage/sounds') }}/'+setting.sound.shot.audio" autoplay></audio>
        </template>

        <template x-if="setting.checking.status && setting.checking.wins.length < 1">
            <div class="w-full h-full absolute top-0 bottom-0 left-0 right-0 z-20 flex flex-col justify-center items-center bg-gray-500 bg-opacity-70 transition-all">

                <audio id="win" x-bind:src="'{{ asset('storage/sounds') }}/'+setting.sound.win.audio" autoplay></audio>

                <div class="w-full md:w-2/5 rounded-t-sm p-6 bg-[#610720] text-white text-center text-[30px] font-bold">
                    <h3 x-text="'No hay bingo!'"></h3>
                </div>
                <div class="w-full md:w-2/5 rounded-b-sm pb-6 bg-[#610720] text-yellow-600 text-center text-[30px] font-bold">
                    <button type="button" class="p-2 border border-white md:border-black bg-transparent text-white md:text-black rounded-md font-black hover:text-white hover:border-white" x-on:click="setting.checking.status = false">{{ __('Continuar Juego') }}</button>
                </div>
            </div>
        </template>

        <template x-if="setting.checking.status && setting.checking.wins.length > 0">
            <div class="w-full h-full absolute top-0 left-0 z-20 flex flex-col justify-center items-center bg-white bg-opacity-70 p-6">
                
                <audio id="win" x-bind:src="'{{ asset('storage/sounds') }}/'+setting.sound.win.audio" autoplay></audio>
                <audio id="win" x-bind:src="'{{ asset('storage/sounds') }}/'+setting.sound.celebration.audio" autoplay></audio>

                <div class="w-full md:w-2/5 rounded-t-full p-6 bg-[#610720] text-white text-center text-[20px] font-bold border-4 border-yellow-800 border-b-0">
                    <h3 x-text="'Has ganado!'"></h3>
                </div>

                <div class="w-full md:w-2/5 p-6 bg-[#610720] bg-opacity-50 text-white text-center text-[15px] font-bold flex flex-row overflow-x-auto border-4 border-yellow-800 border-b-0 border-t-0 bg-gif-win" :class="setting.checking.wins.length > 2 ? '' : 'justify-center'">
                    <template x-for="win in setting.checking.wins">
                        <x-carton-win/>
                    </template>
                </div>

                <div class="w-full md:w-2/5 rounded-b-full p-0 bg-[#610720] text-white text-center text-[20px] font-bold grid grid-cols-2 border-4 border-yellow-800 border-t-0">
                    <button type="button" class="p-2 bg-transparent border-r text-center text-white font-bold overflow-hidden cursor-pointer active:ring-0 active:outline-0" x-on:click="save">{{ __('Continuar') }}</button>
                    <button type="button" class="p-2 bg-transparent border-l text-center text-white font-bold overflow-hidden cursor-pointer active:ring-0 active:outline-0" x-on:click="finish">{{ __('Finalizar') }}</button>
                </div>

                
            </div>
        </template>

        <div x-show="setting.open" x-cloak class="fixed inset-0 z-40">
            <div class="absolute inset-0 bg-black/60" @click="setting.open = false"
                x-show="setting.open" x-transition:enter="transition-opacity duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"></div>

            <div class="absolute right-0 top-0 h-full w-full max-w-sm overflow-y-auto border-l border-white/10 bg-indigo-950/95 p-6 backdrop-blur-xl"
                x-show="setting.open"
                x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full">

                <div class="mb-6 flex items-center justify-between">
                    <h2 class="text-xl font-black">Configuración</h2>
                    <button @click="setting.open = false" class="rounded-full p-2 hover:bg-white/10 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M18.3 5.71 12 12l6.3 6.29-1.41 1.42L10.59 13.4 4.3 19.71 2.88 18.3 9.17 12 2.88 5.71 4.3 4.29l6.29 6.3 6.29-6.3z"/>
                        </svg>
                    </button>
                </div>

                <div class="space-y-6">
                    {{-- Sonido --}}
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold">Sonido del juego</p>
                            <p class="text-xs text-indigo-200/60">Efectos al cantar cada bola</p>
                        </div>
                        <button @click="soundOn = !soundOn"
                                :class="soundOn ? 'bg-fuchsia-500' : 'bg-white/10'"
                                class="relative h-7 w-12 rounded-full transition">
                            <span class="absolute top-1 h-5 w-5 rounded-full bg-white transition-all"
                                :class="soundOn ? 'left-6' : 'left-1'"></span>
                        </button>
                    </div>

                    {{-- Volumen --}}
                    <div :class="!soundOn && 'opacity-40 pointer-events-none'">
                        <div class="mb-2 flex items-center justify-between">
                            <p class="text-sm font-semibold">Volumen</p>
                            <span class="text-xs text-indigo-200/70" x-text="volume + '%'"></span>
                        </div>
                        <input type="range" min="0" max="100" x-model="volume"
                            class="w-full accent-fuchsia-500">
                    </div>

                    {{-- Selección automática --}}
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold">Selección automática</p>
                            <p class="text-xs text-indigo-200/60">Marca tus cartones al cantarse cada bola</p>
                        </div>
                        <button @click="autoSelect = !autoSelect"
                                :class="autoSelect ? 'bg-fuchsia-500' : 'bg-white/10'"
                                class="relative h-7 w-12 rounded-full transition">
                            <span class="absolute top-1 h-5 w-5 rounded-full bg-white transition-all"
                                :class="autoSelect ? 'left-6' : 'left-1'"></span>
                        </button>
                    </div>

                    {{-- Series automáticas --}}
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold">Series automáticas</p>
                            <p class="text-xs text-indigo-200/60">Continúa a la siguiente serie sin confirmar</p>
                        </div>
                        <button @click="autoSeries = !autoSeries"
                                :class="autoSeries ? 'bg-fuchsia-500' : 'bg-white/10'"
                                class="relative h-7 w-12 rounded-full transition">
                            <span class="absolute top-1 h-5 w-5 rounded-full bg-white transition-all"
                                :class="autoSeries ? 'left-6' : 'left-1'"></span>
                        </button>
                    </div>

                    {{-- Velocidad de llamado --}}
                    <div>
                        <p class="mb-2 text-sm font-semibold">Velocidad de llamado</p>
                        <div class="grid grid-cols-3 gap-2">
                            <template x-for="opt in [{v:'lenta',l:'Lenta'},{v:'normal',l:'Normal'},{v:'rapida',l:'Rápida'}]" :key="opt.v">
                                <button @click="callSpeed = opt.v"
                                        :class="callSpeed === opt.v ? 'bg-fuchsia-500 border-fuchsia-400' : 'bg-white/5 border-white/15 hover:bg-white/10'"
                                        class="rounded-xl border-2 py-2 text-xs font-bold transition">
                                    <span x-text="opt.l"></span>
                                </button>
                            </template>
                        </div>
                    </div>

                    {{-- Vibración --}}
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold">Vibración</p>
                            <p class="text-xs text-indigo-200/60">Solo en dispositivos móviles compatibles</p>
                        </div>
                        <button @click="vibration = !vibration"
                                :class="vibration ? 'bg-fuchsia-500' : 'bg-white/10'"
                                class="relative h-7 w-12 rounded-full transition">
                            <span class="absolute top-1 h-5 w-5 rounded-full bg-white transition-all"
                                :class="vibration ? 'left-6' : 'left-1'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>


        <!-- <p class="text-[25px] p-4" x-text="setting.checking.wins.length"></p> -->

        <section class="w-full flex">
            
            <!-- CAROUSEL -->
            <div class="w-full relative p-2 pb-12 flex flex-row flex-nowrap items-center justify-center">
                <div class="bg-transparent focus:bg-gray-200 focus:bg-opacity-50 hover:bg-gray-200 hover:bg-opacity-50 text-black w-full flex justify-around items-center absolute bottom-0 left-0 z-10">

                    <template x-if="setting.section.submodes.enabled || setting.section.board.enabled">
                        <div class="flex flex-row justify-center items-center">

                            <template x-if="setting.section.submodes.enabled">
                                <a class="flex flex-nowrap items-center rounded-sm cursor-pointer px-1 mx-1 focus:tooltip focus:tooltip-top focus:tooltip-warning text-white" :class="setting.section.submodes.extended ? 'bg-[#C18C1A]' : 'bg-[#610720]'" data-tip="{{ __('Winning ways') }}" x-on:click="toggleView('submodes')">
                                    <svg class="w-[25px] h-[25px]" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28"><path fill="currentColor" d="M3 6.75A3.75 3.75 0 0 1 6.75 3H9.5v6.5H3V6.75ZM3 11v6h6.5v-6H3Zm0 7.5v2.75A3.75 3.75 0 0 0 6.75 25H9.5v-6.5H3Zm8 6.5h6v-6.5h-6V25Zm7.5 0h2.75A3.75 3.75 0 0 0 25 21.25V18.5h-6.5V25Zm6.5-8v-6h-6.5v6H25Zm0-7.5V6.75A3.75 3.75 0 0 0 21.25 3H18.5v6.5H25ZM17 3h-6v6.5h6V3Zm0 8v6h-6v-6h6Z"/></svg>
                                    <p class="font-thin hidden md:inline-block">{{ __('Ways') }}</p>
                                </a>
                            </template>

                            <template x-if="setting.section.board.enabled">
                                <a class="flex flex-nowrap items-center rounded-sm cursor-pointer px-1 mx-1 focus:tooltip focus:tooltip-top focus:tooltip-warning text-white" :class="setting.section.board.extended ? 'bg-[#C18C1A]' : 'bg-[#610720]'" data-tip="{{ __('View Board') }}" x-on:click="toggleView('board')">
                                    <svg class="w-[25px] h-[25px]" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 256 256"><path fill="currentColor" d="M224 44H32a12 12 0 0 0-12 12v136a20 20 0 0 0 20 20h176a20 20 0 0 0 20-20V56a12 12 0 0 0-12-12ZM44 116h32v24H44Zm56 0h112v24H100Zm112-48v24H44V68ZM44 164h32v24H44Zm56 24v-24h112v24Z"/></svg>
                                    <p class="font-thin hidden md:inline-block">{{ __('Board') }}</p>
                                </a>
                            </template>

                        </div>
                    </template>
                    
                    <template x-if="setting.section.screen.width <= 700">
                        <div class="flex justify-center items-center">
                            <a class="pl-4 cursor-pointer text-[#C18C1A]" x-on:click="moveScroll(0, -222, '.slider', true)">
                                <svg class="w-[30px] h-[30px]" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="M24 0v24H0V0h24ZM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018Zm.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01l-.184-.092Z"/><path fill="currentColor" d="M6 3a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3H6Zm7.707 6.879L11.586 12l2.121 2.121a1 1 0 0 1-1.414 1.415l-2.829-2.829a1 1 0 0 1 0-1.414l2.829-2.829a1 1 0 1 1 1.414 1.415Z"/></g></svg>
                            </a>
                            <a class="pr-4 cursor-pointer text-[#C18C1A]" x-on:click="moveScroll(0, 222, '.slider', true)">
                                <svg class="w-[30px] h-[30px]" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="M24 0v24H0V0h24ZM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018Zm.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01l-.184-.092Z"/><path fill="currentColor" d="M6 3a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3H6Zm4.293 11.121L12.414 12l-2.121-2.121a1 1 0 1 1 1.414-1.415l2.829 2.829a1 1 0 0 1 0 1.414l-2.829 2.829a1 1 0 1 1-1.414-1.415Z"/></g></svg>
                            </a>
                        </div>
                    </template>

                    <!-- <button type="button" class="py-1 px-6 py-3 bg-[#610720] rounded text-center text-white font-bold overflow-hidden cursor-pointer active:ring-0 active:outline-0" x-on:click="bingo">{{ __('Bingo') }}</button> -->

                </div>

            </div>

        </section>

        <div class="grid grid-cols-6 grid-rows-5 gap-4 rounded-3xl border border-fuchsia-400/30 bg-white/[0.07] p-5 shadow-2xl shadow-fuchsia-950/40 ring-1 ring-fuchsia-500/10 backdrop-blur">
            
            <div class="rounded-3xl border border-fuchsia-400/30 bg-white/[0.07] p-5 shadow-2xl shadow-fuchsia-950/40 ring-1 ring-fuchsia-500/10 backdrop-blur">
                {{-- Logo --}}
                <span class="text-xs font-medium uppercase tracking-wide text-fuchsia-200/80">Partida en curso</span>
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight">BINGO<span class="text-fuchsia-400">75</span></h1>
            </div>

            {{-- Boton Bingo --}}
            <div class="rounded-3xl flex items-center justify-center">
                <button @click="bingo"
                        class="sticky bottom-4 z-20 mt-6 flex w-auto h-auto max-h-[80px] items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-fuchsia-500 to-pink-500 px-6 py-5 text-xl font-black uppercase tracking-wide text-white shadow-2xl shadow-fuchsia-900/50 transition hover:scale-[1.02] active:scale-100 animate-pulse-slow lg:static cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2 9.5 8.5 3 9l5 4.5L6.5 20 12 16.5 17.5 20 16 13.5l5-4.5-6.5-.5z"/>
                    </svg>
                    ¡BINGO!
                </button>
            </div>

            {{-- Sequence --}}
            <div class="col-span-3 rounded-3xl flex flex-row flex-nowrap">

                <div id="sequences" class="flex flex-row flex-nowrap items-center overflow-x-scroll px-4">
                    <template x-if="sequence.length > 0">
                        <template x-for="seq in sequence">
                            <div class="w-[40px] min-w-[40px] min-h-[40px] h-[40px] rounded-full overflow-hidden flex items-center justify-center p-2 text-white font-thin m-2 last:scale-125 last:p-3 last:ml-6 last:font-bold" :class="seq.color">
                                <p class="flex items-center justify-center bg-white rounded-full text-black text-[12px] md:text-[14px] p-1">
                                    <b x-text="seq.letter+seq.number"></b>
                                </p>
                            </div>
                        </template>
                    </template>
                </div>

                <button type="button" class="sticky bottom-4 z-20 mt-6 flex w-auto h-auto max-h-[80px] items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-fuchsia-500 to-pink-500 px-6 py-5 text-xl font-black uppercase tracking-wide text-white shadow-2xl shadow-fuchsia-900/50 transition hover:scale-[1.02] active:scale-100 animate-pulse-slow lg:static cursor-pointer" :class="inRound ? 'cursor-not-allowed' : ''" x-on:click="setRound(); setTimeout(() => { moveScroll(0, 999999,'#sequences') }, 1000)" :disabled="inRound">{{ __('Next Ball') }}</button>
                
            </div>

            {{-- Setting --}}
            <div class="col-start-6 flex items-center justify-center gap-2">
                <button @click="setting.open = true" data-tip="{{ __('Setting') }}"
                    class="tooltip tooltip-bottom tooltip-warning rounded-md border border-white/10 bg-white/5 p-3 text-indigo-100 hover:bg-white/10 transition flex flex-row items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19.14 12.94a7.14 7.14 0 0 0 .06-.94 7.14 7.14 0 0 0-.06-.94l2.03-1.58a.5.5 0 0 0 .12-.64l-1.92-3.32a.5.5 0 0 0-.6-.22l-2.39.96a7.3 7.3 0 0 0-1.63-.94l-.36-2.54a.5.5 0 0 0-.5-.42h-3.84a.5.5 0 0 0-.5.42l-.36 2.54c-.59.24-1.14.56-1.63.94l-2.39-.96a.5.5 0 0 0-.6.22L2.79 8.84a.5.5 0 0 0 .12.64L4.94 11a7.14 7.14 0 0 0 0 1.88l-2.03 1.58a.5.5 0 0 0-.12.64l1.92 3.32c.14.24.42.32.6.22l2.39-.96c.49.38 1.04.7 1.63.94l.36 2.54a.5.5 0 0 0 .5.42h3.84a.5.5 0 0 0 .5-.42l.36-2.54c.59-.24 1.14-.56 1.63-.94l2.39.96c.24.1.46 0 .6-.22l1.92-3.32a.5.5 0 0 0-.12-.64l-2.03-1.58zM12 15.5A3.5 3.5 0 1 1 12 8.5a3.5 3.5 0 0 1 0 7z"/>
                    </svg>
                    <p class="md:hidden text-xs">&nbsp;{{ __('Setting') }}</p>
                </button>
                <!-- <div x-show="sequence.length > 0" class="flex flex-col justify-center items-center gap-1">
                    <span class="text-xs text-indigo-200/70">Última bola</span>
                    <div class="flex h-11 w-11 items-center justify-center rounded-full bg-fuchsia-500 font-black shadow-lg shadow-fuchsia-900/40 text-sm"
                        x-text="sequence[sequence.length - 1].letter+sequence[sequence.length - 1].number">
                    </div>
                </div> -->
                <button @click="stop" data-tip="{{ __('Pause') }}"
                    class="tooltip tooltip-bottom tooltip-warning rounded-md border border-white/10 bg-white/5 p-3 text-indigo-100 hover:bg-white/10 transition flex flex-row items-center">
                    <svg name="pause" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"><path fill="currentColor" d="M10 16q.425 0 .713-.288T11 15V9q0-.425-.288-.713T10 8q-.425 0-.713.288T9 9v6q0 .425.288.713T10 16Zm4 0q.425 0 .713-.288T15 15V9q0-.425-.288-.713T14 8q-.425 0-.713.288T13 9v6q0 .425.288.713T14 16ZM4 20q-.825 0-1.413-.588T2 18V6q0-.825.588-1.413T4 4h16q.825 0 1.413.588T22 6v12q0 .825-.588 1.413T20 20H4Z"/></svg>
                    <p class="md:hidden text-xs">&nbsp;{{ __('Pause') }}</p>
                </button>
                <button @click="finish" data-tip="{{ __('Close') }}"
                    class="tooltip tooltip-bottom tooltip-warning rounded-md border border-white/10 bg-white/5 p-3 text-indigo-100 hover:bg-white/10 transition flex flex-row items-center">
                    <svg name="close" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"><path fill="currentColor" d="M19 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2m-3.4 14L12 13.4L8.4 17L7 15.6l3.6-3.6L7 8.4L8.4 7l3.6 3.6L15.6 7L17 8.4L13.4 12l3.6 3.6l-1.4 1.4Z"/></svg>
                    <p class="md:hidden text-xs">&nbsp;{{ __('Close') }}</p>
                </button>
            </div>

            {{-- Bolillero --}}
            <div class="row-span-4 row-start-2 rounded-3xl border border-fuchsia-400/30 bg-white/[0.07] p-5 shadow-2xl shadow-fuchsia-950/40 ring-1 ring-fuchsia-500/10 backdrop-blur">Bolillero</div>

            {{-- Cartones --}}
            <div class="col-span-4 row-span-3 row-start-2 rounded-3xl border border-fuchsia-400/30 bg-white/[0.07] p-5 shadow-2xl shadow-fuchsia-950/40 ring-1 ring-fuchsia-500/10 backdrop-blur">
                <div class="slider w-full flex flex-row flex-nowrap overflow-x-auto md:justify-center">
                    <template x-for="(carton, number) in cartons">
                        <div class="slider-item">
                            <x-carton3 :selectable="true"/>
                        </div>
                    </template>
                </div>
            </div>

            {{-- Modos --}}
            <div class="row-span-3 col-start-6 row-start-2 rounded-3xl border border-fuchsia-400/30 bg-white/[0.07] p-5 shadow-2xl shadow-fuchsia-950/40 ring-1 ring-fuchsia-500/10 backdrop-blur">
                
                {{-- Ultima Bola --}}
                <div id="content-bounce" class="w-full h-full flex flex-row items-center justify-center p-0 px-12 md:p-3 md:px-12 overflow-x-auto">
                    <template x-if="sequence.length > 0">
                        <div class="ball-bounce w-[50px] min-w-[50px] min-h-[50px] h-[50px] rounded-full overflow-hidden flex items-center justify-center p-3 text-white font-thin m-2 last:scale-125 last:p-4 last:ml-12 last:font-bold" :class="sequence[sequence.length - 1].color"> <!-- :class="(round ? 'hidden w-[1px] h-[1px]' : '')" -->
                            <p class="flex items-center justify-center bg-white rounded-full text-black text-[12px] md:text-[14px] p-1">
                                <b x-text="sequence[sequence.length - 1].letter+sequence[sequence.length - 1].number"></b>
                            </p>
                        </div>
                    </template>
                </div>

                {{-- Modos --}}
                <template x-if="setting.section.submodes.extended">
                    <article class="border w-full overflow-x-auto" x-show="submodes.length">
                        <div class="flex flex-row items-center justify-center font-thin pb-4 rounded-t-md p-4 text-center border" >
                            <template x-for="submode in submodes">
                                <div class="flex flex-col items-center justify-center m-1">
                                    <!-- <p class="block text-center text-black text-[12px]" x-text="submode.name"></p> -->
                                    <div class="w-[65px] h-[65px] bg-gray-400 rounded-md p-1 flex items-center justify-center">
                                        <template x-for="col in submode.columns">
                                            <div class="flex flex-col items-center justify-center">

                                                <template x-for="row in submode.rows">

                                                    <div :class="(submode.coordinates.findIndex(coord => coord.x == (col-1) && coord.y == (row-1) ) > -1) ? 'bg-gray-800' : 'bg-gray-100'" class="p-[4px] m-[2px]"></div>

                                                </template>

                                            </div>
                                        </template>
                                    </div>
                                </div>                    
                            </template>
                        </div>
                    </article>
                </template>

            </div>

            {{-- Board --}}
            <div class="col-span-5 col-start-2 row-start-5 rounded-3xl border border-fuchsia-400/30 bg-white/[0.07] p-5 shadow-2xl shadow-fuchsia-950/40 ring-1 ring-fuchsia-500/10 backdrop-blur">
                <template x-if="setting.section.board.extended">
                    <article class="border w-full">
                        <template x-if="board.length > 0">
                            <table class="table-auto border rounded-md text-white text-[10px] md:text-[14px] w-full">
                                <thead>
                                    <tr>
                                        <th :colspan="(board[0].ranges.length + 1)" class="bg-[#4c0519] text-white" x-text="'Marker'"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="row in board">
                                        <tr class="border text-[#4c0519] transition-all">
                                            <th class="bg-[#4c0519] text-white" x-text="row.letter"></th>
                                            <template x-for="range in row.ranges">
                                                <td class="border text-center text-black overflow-hidden bg-white transition-all" :class="(range.active) ? 'bg-yellow-600 rounded-full' : ''" x-text="range.number"></td>
                                            </template>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </template>
                    </article>
                </template>
            </div>

        </div>
    
    </div>

</x-guest-layout>