<x-guest-layout>

    <div x-data="Simulator" x-init="start(); setTimeout(() => { moveScroll(0, 999999, '#sequences') }, 1000);" @resize.window='setting.section.screen.width = window.innerWidth; setting.section.screen.height = window.innerHeight;' class="w-full mx-auto max-w-7xl relative">
    <!-- class="w-full rounded-lg overflow-hidden flex flex-col relative" -->

        <template x-if="sequence.length == 0">
            <audio id="start" x-bind:src="'{{ asset('storage/sounds') }}/'+setting.lang+'/'+setting.gender+'/'+setting.sound.start.audio" autoplay></audio>
        </template>

        <template x-if="setting.sound.serie.audio !== ''">
            <audio id="serie" x-bind:src="'{{ asset('storage/sounds') }}/'+setting.lang+'/'+setting.gender+'/'+setting.sound.serie.audio+'.mp3'" autoplay></audio>
        </template>

        <template x-if="setting.sound.bolillero.audio !== ''">
            <audio id="bolillero" x-bind:src="'{{ asset('storage/sounds') }}/effects/'+setting.sound.bolillero.audio" class="hidden" autoplay loop controls x-bind:volume="setting.sound.bolillero.volume"></audio>
        </template>

        <template x-if="setting.sound.shot.audio !== ''">
            <audio id="shot" x-bind:src="'{{ asset('storage/sounds') }}/effects/'+setting.sound.shot.audio" autoplay></audio>
        </template>

        {{-- Setting Options --}}
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
                    <h2 class="text-xl font-black">{{ __('Configuration') }}</h2>
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
                            <p class="text-sm font-semibold">{{ __('Game Sounds') }}</p>
                            <p class="text-xs text-indigo-200/60">{{ __('Efectos al cantar cada bola') }}</p>
                        </div>
                        <button @click="setting.sound.general.active = !setting.sound.general.active"
                                :class="setting.sound.general.active ? 'bg-fuchsia-500' : 'bg-white/10'"
                                class="relative h-7 w-12 rounded-full transition">
                            <span class="absolute top-1 h-5 w-5 rounded-full bg-white transition-all"
                                :class="setting.sound.general.active ? 'left-6' : 'left-1'"></span>
                        </button>
                    </div>

                    {{-- Volumen --}}
                    <div :class="!setting.sound.general.active && 'opacity-40 pointer-events-none'">
                        <div class="mb-2 flex items-center justify-between">
                            <p class="text-sm font-semibold">Volumen</p>
                            <span class="text-xs text-indigo-200/70" x-text="setting.sound.general.volume + '%'"></span>
                        </div>
                        <input type="range" min="0" max="100" x-model="setting.sound.general.volume"
                            class="w-full accent-fuchsia-500">
                    </div>

                    {{-- Selección automática --}}
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold">Selección automática</p>
                            <p class="text-xs text-indigo-200/60">Marca tus cartones al cantarse cada bola</p>
                        </div>
                        <button @click="toggleAutoSelect()"
                                :class="setting.autoSelect ? 'bg-fuchsia-500' : 'bg-white/10'"
                                class="relative h-7 w-12 rounded-full transition">
                            <span class="absolute top-1 h-5 w-5 rounded-full bg-white transition-all"
                                :class="setting.autoSelect ? 'left-6' : 'left-1'"></span>
                        </button>
                    </div>

                    {{-- Series automáticas --}}
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold">Series automáticas</p>
                            <p class="text-xs text-indigo-200/60">Continúa a la siguiente serie sin confirmar</p>
                        </div>
                        <button @click="toggleAutoSeries()"
                                :class="setting.autoSeries ? 'bg-fuchsia-500' : 'bg-white/10'"
                                class="relative h-7 w-12 rounded-full transition">
                            <span class="absolute top-1 h-5 w-5 rounded-full bg-white transition-all"
                                :class="setting.autoSeries ? 'left-6' : 'left-1'"></span>
                        </button>
                    </div>

                    {{-- Velocidad de llamado --}}
                    <div x-show="setting.autoSeries" class="transition ease-out duration-100">
                        <p class="mb-2 text-sm font-semibold">Velocidad de llamado</p>
                        <div class="grid grid-cols-3 gap-2">
                            <template x-for="opt in [{v:'lenta',l:'Lenta'},{v:'normal',l:'Normal'},{v:'rapida',l:'Rápida'}]" :key="opt.v">
                                <button @click="setting.callSpeed = opt.v"
                                        :class="setting.callSpeed === opt.v ? 'bg-fuchsia-500 border-fuchsia-400' : 'bg-white/5 border-white/15 hover:bg-white/10'"
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
                        <button @click="setting.vibration = !setting.vibration"
                                :class="setting.vibration ? 'bg-fuchsia-500' : 'bg-white/10'"
                                class="relative h-7 w-12 rounded-full transition">
                            <span class="absolute top-1 h-5 w-5 rounded-full bg-white transition-all"
                                :class="setting.vibration ? 'left-6' : 'left-1'"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Alert Lost Bingo --}}
        <template x-if="setting.checking.status && setting.checking.wins.length < 1">
            <div class="flex flex-col items-center justify-center p-12 w-full h-full absolute z-20 top-0 bottom-0 bg-indigo-950/95 mx-auto rounded-md gap-4 transition-all">

                <audio id="win" x-bind:src="'{{ asset('storage/sounds') }}/effects/'+setting.sound.win.audio" autoplay></audio>

                <h1 class="text-2xl sm:text-3xl font-black tracking-tight">BINGO<span class="text-fuchsia-400">75</span></h1>
                <span class="text-xs font-medium uppercase tracking-wide text-fuchsia-200/80 text-center">Partida en curso</span>
                <hr class="border border-white w-1/2">
                <h1 class="text-5xl sm:text-6xl md:text-7xl font-black tracking-tight drop-shadow-lg">
                    {{ __('Invalid bingo') }}
                </h1>

                <span class="mb-3 inline-block rounded-full bg-white/10 px-4 py-1 text-sm font-medium tracking-wide text-fuchsia-200 backdrop-blur text-center">
                    {{ __('The cards does not match the winning combination') }}
                </span>
                <button @click="setting.checking.status = false"
                    class="cursor-pointer group relative inline-flex items-center justify-center gap-2 rounded-2xl bg-fuchsia-500 px-8 py-4 text-lg font-bold text-white shadow-xl shadow-fuchsia-900/40 transition
                            hover:bg-fuchsia-400 hover:-translate-y-0.5 active:translate-y-0 focus:outline-none focus:ring-4 focus:ring-fuchsia-300/50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M8 5v14l11-7L8 5z"/>
                    </svg>
                    {{ __('Continue Game') }}
                </button>

            </div>
        </template>

        {{-- Alert Win Bingo --}}
        <template x-if="setting.checking.status && setting.checking.wins.length > 0">
            <div class="flex flex-col items-center justify-center p-12 w-full h-full absolute z-20 top-0 bottom-0 bg-indigo-950/95 mx-auto rounded-md gap-4">
                
                <audio id="win" x-bind:src="'{{ asset('storage/sounds') }}/'+setting.lang+'/'+setting.gender+'/'+setting.sound.win.audio" autoplay></audio>
                <audio id="win" x-bind:src="'{{ asset('storage/sounds') }}/'+setting.lang+'/'+setting.gender+'/'+setting.sound.celebration.audio" autoplay></audio>

                <h1 class="text-2xl sm:text-3xl font-black tracking-tight">BINGO<span class="text-fuchsia-400">75</span></h1>
                <span class="text-xs font-medium uppercase tracking-wide text-fuchsia-200/80 text-center">Partida Ganada</span>
                <hr class="border border-white w-1/2">
                <h1 class="text-5xl sm:text-6xl md:text-7xl font-black tracking-tight drop-shadow-lg">
                    {{ __('You have won') }}
                </h1>

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

        {{-- Pause --}}
        <template x-if="pause">
            <div class="flex flex-col items-center justify-center p-12 w-full h-full absolute z-20 top-0 bottom-0 bg-indigo-950/95 mx-auto rounded-md gap-4">
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight">BINGO<span class="text-fuchsia-400">75</span></h1>
                <span class="text-xs font-medium uppercase tracking-wide text-fuchsia-200/80 text-center">Partida en curso</span>
                <hr class="border border-white w-1/2">
                <h1 class="text-5xl sm:text-6xl md:text-7xl font-black tracking-tight drop-shadow-lg">
                    {{ __('Paused') }}
                </h1>
                <button @click="keep"
                    class="cursor-pointer group relative inline-flex items-center justify-center gap-2 rounded-2xl bg-fuchsia-500 px-8 py-4 text-lg font-bold text-white shadow-xl shadow-fuchsia-900/40 transition
                            hover:bg-fuchsia-400 hover:-translate-y-0.5 active:translate-y-0 focus:outline-none focus:ring-4 focus:ring-fuchsia-300/50">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M8 5v14l11-7L8 5z"/>
                    </svg>
                    {{ __('Continue') }}
                </button>
            </div>
        </template>

        {{-- Board Absolute Mobile --}}
        <template x-if="isMobile() && setting.section.board.enabled">
            <div class="w-full p-6 flex flex-col justify-center absolute top-10 z-30 bg-indigo-950/95 mx-auto rounded-md overflow-y-auto" 
                x-show="setting.section.board.extended" @click.outside="setting.section.board.extended = false">
                <h2 class="mb-4 py-2 border-b flex items-center justify-between text-sm font-bold uppercase tracking-wide text-indigo-100">
                    {{ __('Scoreboard') }}
                    <button @click="setting.section.board.extended = false" class="rounded-full p-2 hover:bg-white/10 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M18.3 5.71 12 12l6.3 6.29-1.41 1.42L10.59 13.4 4.3 19.71 2.88 18.3 9.17 12 2.88 5.71 4.3 4.29l6.29 6.3 6.29-6.3z"/>
                        </svg>
                    </button>
                </h2>
                <div class="flex gap-1 font-bold border-[.7em] rounded-md md:rounded-r-none p-0 border-white/50 mx-auto text-[.7em]" 
                    :class="(setting.section.board.orientation === 'V' ? 'flex-row') : 'flex-col'; (setting.section.board.size === 'S' ? 'scale-50' : (setting.section.board.size === 'M' ? 'scale-75' : ''))">
                    <!-- table-auto border rounded-md text-white text-[10px] md:text-[14px] w-full -->
                    <!-- :class="grid-cols-(board[0].ranges.length + 1)" -->
                    <!-- <p class="text-white text-end" x-text="'Board'"></p> -->
                    <template x-for="row in board">
                        <div class="flex flex-col flex-nowrap justify-around items-center transition-all gap-2"
                            :class="setting.section.board.orientation === 'V' ? 'flex-col' : 'flex-row'">
                            <div class="flex items-center justify-center transition p-1.5 w-7 h-7 bg-white/50 text-black" x-text="row.letter"></div>
                            <template x-for="range in row.ranges">
                                <div class="flex flex-col items-center justify-center transition p-1.5 w-7 h-7 rounded border-0" 
                                    :class="(range.active) ? 'bg-fuchsia-400/50' : 'bg-white/5 text-indigo-100/50'" 
                                    :class="setting.section.board.orientation === 'V' ? 'flex-col' : 'flex-row'"
                                    x-text="range.number"></div>
                            </template>
                        </div>
                    </template>
                </div>
            </div>
        </template>

        {{-- Submodes Absolute Mobile --}}
        <template x-if="isMobile() && setting.section.submodes.enabled">
            <div class="w-full p-6 flex flex-col justify-center absolute top-10 z-30 bg-indigo-950/95 mx-auto rounded-md" 
                x-show="setting.section.submodes.extended" @click.outside="setting.section.submodes.extended = false">
                <h2 class="mb-4 py-2 border-b flex items-center justify-between text-sm font-bold uppercase tracking-wide text-indigo-100">
                    {{ __('Winning game modes') }}
                    <button @click="setting.section.submodes.extended = false" class="rounded-full p-2 hover:bg-white/10 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M18.3 5.71 12 12l6.3 6.29-1.41 1.42L10.59 13.4 4.3 19.71 2.88 18.3 9.17 12 2.88 5.71 4.3 4.29l6.29 6.3 6.29-6.3z"/>
                        </svg>
                    </button>
                </h2>
                <div class="flex flex-col justify-around text-center">
                    <!-- <span class="text-xs text-indigo-200/70">{{ __('Modos Ganadores') }}</span> -->
                    <template x-for="submode in submodes">
                        <div class="flex flex-col items-center justify-center m-1">
                            <div class="w-[85px] h-[85px] bg-gray-400 rounded-md p-1 flex items-center justify-center scale-75">
                                <template x-for="col in submode.columns">
                                    <div class="flex flex-col items-center justify-center">
                                        <template x-for="row in submode.rows">
                                            <div :class="(submode.coordinates.findIndex(coord => coord.x == (col-1) && coord.y == (row-1) ) > -1) ? 'bg-indigo-950' : 'bg-gray-100'" class="rounded-xs p-[5px] m-[3px]"></div>
                                        </template>
                                    </div>
                                </template>
                            </div>
                            <p class="text-xs text-indigo-200/70" x-text="submode.name"></p>
                        </div>                    
                    </template>
                </div>
            </div>
        </template>

        <template x-if="setting.intentFinish">
            <div class="flex flex-col items-center justify-center p-12 w-full h-full absolute z-20 top-0 bottom-0 bg-indigo-950/95 mx-auto rounded-md gap-4">
                <h1 class="text-2xl sm:text-3xl font-black tracking-tight">BINGO<span class="text-fuchsia-400">75</span></h1>
                <span class="text-xs font-medium uppercase tracking-wide text-fuchsia-200/80 text-center">Al confirmar se perdera los avances</span>
                <hr class="border border-white w-1/2">
                <span class="mb-3 inline-block rounded-full bg-white/10 px-4 py-1 text-sm font-medium tracking-wide text-fuchsia-200 backdrop-blur">
                    ¿Desea finalizar el juego?
                </span>
                <div class="grid grid-cols-2 gap-3">
                    <button type="button" x-on:click="finish()"
                        class="inline-flex items-center justify-center gap-2 rounded-2xl border-2 border-white/40 bg-white/5 px-8 py-4 text-lg font-bold text-white backdrop-blur transition hover:bg-fuchsia-400 hover:-translate-y-0.5 active:translate-y-0 focus:outline-none focus:ring-4 focus:ring-fuchsia-300/50">
                        Si
                    </button>
                    <button type="button" x-on:click="setting.intentFinish = false"
                        class="inline-flex items-center justify-center gap-2 rounded-2xl border-2 border-white/40 bg-white/5 px-8 py-4 text-lg font-bold text-white backdrop-blur transition bg-fuchsia-400 hover:-translate-y-0.5 active:translate-y-0 focus:outline-none focus:ring-4 focus:ring-fuchsia-300/50">
                        No
                    </button>
                </div>
            </div>
        </template>

        <div class="flex flex-col gap-1 rounded-md p-5 shadow-2xl shadow-fuchsia-950/40 ring-1 ring-fuchsia-500/10 backdrop-blur overflow-hidden">
            <!-- bg-black/50 -->

            <!-- FILA 1 -->
            <div class="flex flex-row justify-between">

                {{-- Logo --}}
                <div class="flex flex-col items-center justify-center">
                    <h1 class="text-2xl sm:text-3xl font-black tracking-tight">BINGO<span class="text-fuchsia-400">75</span></h1>
                    <span class="text-xs font-medium uppercase tracking-wide text-fuchsia-200/80 text-center">Partida en curso</span>
                </div>

                {{-- Setting --}}
                <div class="flex items-center justify-center gap-2">
                    <button type="button" @click="setting.open = true" data-tip="{{ __('Setting') }}"
                        class="tooltip tooltip-bottom tooltip-warning rounded-md border border-white/10 bg-white/5 p-3 text-indigo-100 hover:bg-white/10 transition flex flex-col items-center justify-center">
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
                    <button type="button" @click="stop" data-tip="{{ __('Pause') }}"
                        class="tooltip tooltip-bottom tooltip-warning rounded-md border border-white/10 bg-white/5 p-3 text-indigo-100 hover:bg-white/10 transition flex flex-col items-center justify-center">
                        <svg name="pause" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"><path fill="currentColor" d="M10 16q.425 0 .713-.288T11 15V9q0-.425-.288-.713T10 8q-.425 0-.713.288T9 9v6q0 .425.288.713T10 16Zm4 0q.425 0 .713-.288T15 15V9q0-.425-.288-.713T14 8q-.425 0-.713.288T13 9v6q0 .425.288.713T14 16ZM4 20q-.825 0-1.413-.588T2 18V6q0-.825.588-1.413T4 4h16q.825 0 1.413.588T22 6v12q0 .825-.588 1.413T20 20H4Z"/></svg>
                        <p class="md:hidden text-xs">&nbsp;{{ __('Pause') }}</p>
                    </button>
                    <button type="button" @click="intentFinish" data-tip="{{ __('Close') }}"
                        class="tooltip tooltip-bottom tooltip-warning rounded-md border border-white/10 bg-white/5 p-3 text-indigo-100 hover:bg-white/10 transition flex flex-col items-center justify-center">
                        <svg name="close" class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24"><path fill="currentColor" d="M19 3H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2m-3.4 14L12 13.4L8.4 17L7 15.6l3.6-3.6L7 8.4L8.4 7l3.6 3.6L15.6 7L17 8.4L13.4 12l3.6 3.6l-1.4 1.4Z"/></svg>
                        <p class="md:hidden text-xs">&nbsp;{{ __('Close') }}</p>
                    </button>
                </div>

            </div>

            <!-- FILA 2 -->
            <div class="grid grid-cols-1 md:grid-cols-5 gap-2">

                <div class="hidden md:flex flex-col md:col-span-2">
                    <template x-if="setting.section.submodes.enabled">
                        <!-- <h2 class="mb-4 text-sm font-bold uppercase tracking-wide text-indigo-100">{{ __('Modos Ganadores') }}</h2> -->
                        <div class="flex flex-row text-center">
                            <!-- <span class="text-xs text-indigo-200/70">{{ __('Modos Ganadores') }}</span> -->
                            <template x-for="submode in submodes">
                                <div class="flex flex-col items-center justify-center m-1">
                                    <div class="w-[85px] h-[85px] bg-gray-400 rounded-md p-1 flex items-center justify-center scale-75">
                                        <template x-for="col in submode.columns">
                                            <div class="flex flex-col items-center justify-center">
                                                <template x-for="row in submode.rows">
                                                    <div :class="(submode.coordinates.findIndex(coord => coord.x == (col-1) && coord.y == (row-1) ) > -1) ? 'bg-indigo-950' : 'bg-gray-100'" class="rounded-xs p-[5px] m-[3px]"></div>
                                                </template>
                                            </div>
                                        </template>
                                    </div>
                                    <p class="text-xs text-indigo-200/70" x-text="submode.name"></p>
                                </div>                    
                            </template>
                        </div>
                    </template>
                </div>

                {{-- Sequences --}}
                <div id="sequences" class="md:col-span-2 flex flex-row flex-nowrap items-center overflow-y-hidden p-4">
                    <template x-if="sequence.length > 0">
                        <template x-for="(seq, inSeq) in sequence.slice(-6)">
                            <div class="w-[40px] h-[40px] rounded-full overflow-hidden flex items-center justify-center p-2 text-white font-thin m-2 last:scale-125 last:p-3 last:ml-6 last:font-bold" :class="seq.color+' w-['+inSeq+'0px] h-['+inSeq+'0px]'">
                                <!-- min-w-[40px] min-h-[40px] -->
                                <p class="flex items-center justify-center bg-white rounded-full text-black text-[12px] md:text-[14px] p-1">
                                    <b x-text="seq.letter+seq.number"></b>
                                </p>
                            </div>
                        </template>
                    </template>
                </div>

                <div class="flex flex-row flex-nowrap items-center justify-between md:justify-end gap-2 m-2">
                    {{-- Botones en mobiles para ver modos ganadores y tablero de marcación --}}
                    <div class="grid grid-cols-2 gap-0 md:hidden">
                        <button type="button" @click="setting.section.submodes.extended = true";
                            class="inline-flex items-center justify-center gap-2 rounded-l-2xl border-2 border-white/40 bg-white/5 px-8 py-4 text-lg font-bold text-white backdrop-blur transition hover:bg-fuchsia-400 hover:-translate-y-0.5 active:translate-y-0 focus:outline-none focus:ring-4 focus:ring-fuchsia-300/50">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path d="M0 0h24v24H0z" fill="none" />
                                <path fill="currentColor" d="M12 9a3 3 0 0 1 3 3a3 3 0 0 1-3 3a3 3 0 0 1-3-3a3 3 0 0 1 3-3m0-4.5c5 0 9.27 3.11 11 7.5c-1.73 4.39-6 7.5-11 7.5S2.73 16.39 1 12c1.73-4.39 6-7.5 11-7.5M3.18 12a9.821 9.821 0 0 0 17.64 0a9.821 9.821 0 0 0-17.64 0" />
                            </svg>

                            {{ __('Modes') }}
                        </button>
                        <button type="button" @click="setting.section.board.extended = true";
                            class="inline-flex items-center justify-center gap-2 rounded-r-2xl border-2 border-white/40 bg-white/5 px-8 py-4 text-lg font-bold text-white backdrop-blur transition hover:bg-fuchsia-400 hover:-translate-y-0.5 active:translate-y-0 focus:outline-none focus:ring-4 focus:ring-fuchsia-300/50">
                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 24 24">
                                <path d="M0 0h24v24H0z" fill="none" />
                                <path fill="currentColor" d="M12 9a3 3 0 0 1 3 3a3 3 0 0 1-3 3a3 3 0 0 1-3-3a3 3 0 0 1 3-3m0-4.5c5 0 9.27 3.11 11 7.5c-1.73 4.39-6 7.5-11 7.5S2.73 16.39 1 12c1.73-4.39 6-7.5 11-7.5M3.18 12a9.821 9.821 0 0 0 17.64 0a9.821 9.821 0 0 0-17.64 0" />
                            </svg>

                            {{ __('Board') }}
                        </button>
                    </div>

                    <template x-if="setting.autoSeries">
                        <div class="flex flex-row flex-nowrap items-center justify-center gap-2">
                            <span class="font-thin text-sm">{{ __('Next ball in') }}</span>
                            <span class="font-bold text-[58] border border-white rounded-md p-2 text-center" 
                                x-text="( (setting.timeAutoSeries.countDown.currentTime < 10) ? '0' : '' )+setting.timeAutoSeries.countDown.currentTime">
                            </span>
                            <span class="font-thin text-sm">{{ __('Seconds') }}</span>
                        </div>
                    </template>
                    <template x-if="!setting.autoSeries">
                        <button type="button" class="flex w-auto h-auto max-h-[80px] items-center justify-center gap-2 rounded-2xl md:rounded-0 md:rounded-tr-2xl bg-gradient-to-r from-fuchsia-500 to-pink-500 px-6 py-5 text-xl font-black uppercase tracking-wide text-white shadow-2xl shadow-fuchsia-900/50 transition hover:scale-[1.02] active:scale-100 animate-pulse-slow cursor-pointer" :class="inRound ? 'cursor-not-allowed' : ''" x-on:click="setRound(); setTimeout(() => { moveScroll(0, 999999,'#sequences') }, 1000)" :disabled="inRound">{{ __('Click Next Ball') }}</button>
                    </template>
                </div>
                
            
            </div>

            <!-- FILA 3 -->
            <div class="flex flex-row flex-nowrap justify-center">

                <div class="hidden md:flex flex-col">
                    <template x-if="setting.section.board.enabled && setting.section.board.extended">
                        <div class="flex gap-1 font-bold border-[.7em] rounded-md md:rounded-r-none p-0 border-white/50 mx-auto text-[.7em]" 
                            :class="setting.section.board.orientation === 'V' ? 'flex-row' : 'flex-col'; setting.section.board.size === 'S' ? 'scale-50' : setting.section.board.size == 'M' ? 'scale-75' : '';">
                            <!-- table-auto border rounded-md text-white text-[10px] md:text-[14px] w-full -->
                            <!-- :class="grid-cols-(board[0].ranges.length + 1)" -->
                            <!-- <p class="text-white text-end" x-text="'Board'"></p> -->
                            <template x-for="row in board">
                                <div class="flex flex-col flex-nowrap justify-around items-center transition-all gap-2"
                                    :class="setting.section.board.orientation === 'V' ? 'flex-col' : 'flex-row'">
                                    <div class="flex items-center justify-center transition p-1.5 w-7 h-7 bg-white/50 text-black" x-text="row.letter"></div>
                                    <template x-for="range in row.ranges">
                                        <div class="flex flex-col items-center justify-center transition p-1.5 w-7 h-7 rounded border-0" 
                                            :class="(range.active) ? 'bg-fuchsia-400/50' : 'bg-white/5 text-indigo-100/50'" 
                                            :class="setting.section.board.orientation === 'V' ? 'flex-col' : 'flex-row'"
                                            x-text="range.number"></div>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </template>
                </div>

                <div class="flex flex-col rounded-2xl md:rounded-l-none border border-fuchsia-400/30 bg-white/[0.07] p-5 shadow-2xl shadow-fuchsia-950/40 ring-1 ring-fuchsia-500/10 backdrop-blur w-full max-h-screen"
                    :class="setting.section.screen.width <= 770 ? 'max-h-[calc(100vh/2)]' : ''">

                    {{-- Cartones --}}
                    <div class="flex flex-col md:flex-row md:justify-center pb-6 w-auto overflow-y-auto gap-4">

                        <template x-for="(carton, number) in cartons">
                            <div class="slider-item flex flex-row justify-center">
                                <x-carton3 :selectable="true"/>
                            </div>
                        </template>

                    </div>

                    {{-- Boton Bingo --}}
                    <button @click="bingo"
                            class="cursor-pointer sticky bottom-4 z-20 pt-4 flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-fuchsia-500 to-pink-500 px-6 py-5 text-xl font-black uppercase tracking-wide text-white shadow-2xl shadow-fuchsia-900/50 transition hover:scale-[1.02] active:scale-100 animate-pulse-slow md:static">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2 9.5 8.5 3 9l5 4.5L6.5 20 12 16.5 17.5 20 16 13.5l5-4.5-6.5-.5z"/>
                        </svg>
                        ¡BINGO!
                    </button>

                </div>

            </div>

        </div>
    
    </div>

</x-guest-layout>