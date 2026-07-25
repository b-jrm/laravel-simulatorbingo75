<x-guest-layout>

    <x-slot name="styles">
        <style>
            @keyframes float {
                0%   { transform: translateY(110vh) translateX(0) rotate(0deg); }
                100% { transform: translateY(-15vh) translateX(20px) rotate(360deg); }
            }
            .animate-float {
                position: absolute;
                top: 0;
                animation-name: float;
                animation-timing-function: linear;
                animation-iteration-count: infinite;
            }
        </style>
    </x-slot>

    <!-- <x-slot name="header"></x-slot> -->
    <div x-data="ConfigSimulator()" x-init="form()" class="flex flex-col items-center justify-center mx-auto px-6 py-8 text-center">

        <div class="pointer-events-none fixed inset-0 overflow-hidden opacity-30">
            <template x-for="ball in balls" :key="ball.id">
                <div
                    class="absolute rounded-full bg-white/90 text-indigo-900 font-extrabold flex items-center justify-center shadow-lg animate-float"
                    :style="`left: ${ball.left}%; width: ${ball.size}px; height: ${ball.size}px; font-size: ${ball.size/2.5}px; animation-delay: ${ball.delay}s; animation-duration: ${ball.duration}s;`"
                    x-text="ball.num"
                ></div>
            </template>
        </div>

        <div class="w-full max-w-lg text-center mb-8">
            <span class="mb-3 inline-block rounded-full bg-white/10 px-4 py-1 text-sm font-medium tracking-wide text-fuchsia-200 backdrop-blur">
                Configura tu partida
            </span>
            <h1 class="text-4xl sm:text-5xl font-black tracking-tight drop-shadow-lg">
                Simulador de <span class="text-fuchsia-400">Bingo</span>
            </h1>
        </div>

        <div class="flex flex-col items-center gap-6 text-[15px] text-white font-thin z-20" x-show="storage !== null">
            <h1 class="text-5xl sm:text-6xl md:text-7xl font-black tracking-tight drop-shadow-lg m-2">
                <span class="text-fuchsia-400">Tiene una</span> Partida <span class="text-fuchsia-400">Sin terminar</span>
            </h1>
            <span class="mb-3 inline-block rounded-full bg-white/10 px-4 py-1 text-sm font-medium tracking-wide text-fuchsia-200 backdrop-blur">
                ¿Desea continuarla?
            </span>
            <div class="grid grid-cols-2 gap-3">
                <button type="button" x-on:click="continueGame()"
                    class="inline-flex items-center justify-center gap-2 rounded-2xl border-2 border-white/40 bg-white/5 px-8 py-4 text-lg font-bold text-white backdrop-blur transition hover:bg-fuchsia-400 hover:-translate-y-0.5 active:translate-y-0 focus:outline-none focus:ring-4 focus:ring-fuchsia-300/50">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 1200 1200">
                        <path d="M0 0h1200v1200H0z" fill="none" />
                        <path fill="currentColor" d="m1004.237 99.152l-611.44 611.441l-198.305-198.305L0 706.779l198.305 198.306l195.762 195.763L588.56 906.355L1200 294.916z" />
                    </svg>
                    Si
                </button>
                <button type="button" x-on:click="newGame()"
                    class="inline-flex items-center justify-center gap-2 rounded-2xl border-2 border-white/40 bg-white/5 px-8 py-4 text-lg font-bold text-white backdrop-blur transition hover:bg-fuchsia-400 hover:-translate-y-0.5 active:translate-y-0 focus:outline-none focus:ring-4 focus:ring-fuchsia-300/50">
                    <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20">
                        <path d="M0 0h20v20H0z" fill="none" />
                        <path fill="currentColor" d="m12.12 10l3.53 3.53l-2.12 2.12L10 12.12l-3.54 3.54l-2.12-2.12L7.88 10L4.34 6.46l2.12-2.12L10 7.88l3.54-3.53l2.12 2.12z" />
                    </svg>
                    No
                </button>
            </div>
        </div>

        <!--  method="POST" action="{{ route('simulator') }}" -->
        <form x-show="storage === null"
                class="w-full max-w-lg rounded-3xl border border-white/10 bg-white/5 p-6 sm:p-8 shadow-2xl backdrop-blur-md space-y-8">
            @csrf

            <div class="w-full h-full absolute top-0 left-0 flex flex-col items-center justify-center text-[15px] text-white font-thin z-20" x-show="progress.status > 0 && progress.status < 100">
                
                <div class="mb-1 text-base font-medium text-purple-700 dark:text-white text-left flex flex-row flex-nowrap w-3/5 pl-1">
                    <p>&#10140;</p>&nbsp;<p class="text-[14px] font-thin" x-text="progress.process">Loading ...</p>
                </div>
                <div class="w-3/5 bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                    <div class="bg-white h-2.5 rounded-full dark:bg-white" x-bind:style="'width: '+progress.status+'%'"></div>
                </div>
                
            </div>

            <div class="z-10">
                <label class="mb-3 block text-sm font-semibold text-indigo-100 text-left">
                    {{ __('Tipo de bingo') }}
                    <!-- <span class="inline-block tooltip tooltip-top tooltip-warning lowercase" data-tip="{{ __('Seleccione el tipo de bingo que quiere jugar') }}&#10;">
                        <svg name="info" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path fill="currentColor" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8Zm8-6.5a6.5 6.5 0 1 0 0 13a6.5 6.5 0 0 0 0-13ZM6.5 7.75A.75.75 0 0 1 7.25 7h1a.75.75 0 0 1 .75.75v2.75h.25a.75.75 0 0 1 0 1.5h-2a.75.75 0 0 1 0-1.5h.25v-2h-.25a.75.75 0 0 1-.75-.75ZM8 6a1 1 0 1 1 0-2a1 1 0 0 1 0 2Z"/></svg>
                    </span> -->
                </label>
                <div class="grid grid-cols-2 gap-3">
                    <template x-for="context in dash.contexts" :key="context.context_id">
                        <button type="button"
                                x-on:click="getModes(context.context_id)"
                                :class="config.context === context.context_id
                                    ? 'bg-fuchsia-500 border-fuchsia-400 shadow-lg shadow-fuchsia-900/40'
                                    : 'bg-white/5 border-white/15 hover:bg-white/10'"
                                class="rounded-xl border-2 px-4 py-3 text-sm font-bold transition">
                            <span x-text="context.name"></span>
                        </button>
                    </template>
                </div>
            </div>

            {{-- Modos ganadores --}}
            <div x-show="dash.modes.length > 0">
                <label class="mb-3 block text-sm font-semibold text-indigo-100 text-left">
                    {{ __('Modo ganador') }}
                </label>
                <div class="grid grid-cols-2 gap-2">
                    <template x-for="mode in dash.modes" :key="mode.mode_id">
                        <label
                            :class="mode.mode_id == config.mode.id
                                ? 'bg-fuchsia-500/90 border-fuchsia-400'
                                : 'bg-white/5 border-white/15 hover:bg-white/10'"
                            class="flex cursor-pointer items-center gap-2 rounded-xl border-2 px-3 py-2.5 text-sm font-medium transition select-none">
                            <input type="radio"
                                :value="mode.mode_id"
                                x-model="config.mode.id"
                                x-on:click="getSubmodes(null, mode.mode_id, mode.name)"
                                class="sr-only"
                            >
                            <svg x-show="mode.mode_id == config.mode.id" class="h-4 w-4 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M9 16.17 4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                            </svg>
                            <span x-text="mode.name"></span>
                        </label>
                    </template>
                </div>

                <div x-show="dash.submodes.length">
                    <p class="my-2 text-md text-indigo-200/60 flex justify-around">
                        <!-- Puedes elegir uno o varios modos de victoria. -->
                        {{ __('Puedes elegir uno o varios modos de victoria') }}
                        &nbsp;
                        <!-- Optional a futuro -->
                        <!-- <label class="relative inline-flex cursor-pointer items-center">
                            <input
                                type="checkbox"
                                class="peer sr-only">

                            <div class="h-8 w-14 rounded-full bg-indigo-500 transition-colors duration-300
                                        peer-checked:bg-indigo-500
                                        peer-not-checked:bg-gray-300">

                                <div class="absolute left-0.5 top-0.5 h-7 w-7 rounded-full bg-white shadow-md
                                            transition-transform duration-300
                                            peer-checked:translate-x-6">
                                </div>

                            </div>
                        </label> -->
                    </p>
                    <div class="flex flex-row items-start text-white font-thin pb-4 col-span-1 md:col-span-2 lg:col-span-4 p-4 text-center overflow-x-auto bg-gray-200 bg-opacity-20">
                        <!-- <Objetive v-bind:types="game.mode"></Objetive> -->
                        <!-- <p>Modos Ganadores Seleccionados</p> -->
                        <template x-for="submode in dash.submodes" :key="submode.submode_id">
                            <div class="relative flex flex-col items-center mx-3">
                                <!-- <p class="block text-center text-white text-[12px]" x-text="submode.name"></p> -->

                                <span x-show="config.submodes.find(ConfigSubmode => ConfigSubmode.submode_id === submode.submode_id)" class="flex items-center justify-center absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-20" @click="setSubmodes(submode.submode_id, true)">
                                    {{-- Chulo de seleccionado --}}
                                    <svg xmlns="http://www.w3.org/2000/svg" width="2em" height="2em" viewBox="0 0 48 48">
                                        <path d="M0 0h48v48H0z" fill="none" />
                                        <circle cx="24" cy="24" r="21" fill="#4CAF50" />
                                        <path fill="#CCFF90" d="M34.6 14.6L21 28.2l-5.6-5.6l-2.8 2.8l8.4 8.4l16.4-16.4z" />
                                    </svg>
                                </span>

                                <a href="#" @click.prevent="setSubmodes(submode.submode_id)" 
                                    class="block w-[80px] h-[80px] bg-gray-400 rounded-md p-1 flex flex-row items-center justify-center">

                                    <template x-for="col in submode.columns">
                                        <div class="flex flex-col items-center justify-center">

                                            <template x-for="row in submode.rows">

                                                <div :class="(submode.coordinates.findIndex(coord => coord.x == (col-1) && coord.y == (row-1) ) > -1) ? 'bg-gray-800' : 'bg-gray-100'" class="p-[5px] mb-1 mr-1 rounded-sm"></div>
                                                
                                            </template>

                                        </div>
                                    </template>
                                    
                                </a>
                            </div>
                        </template>
                        
                    </div>
                </div>
            </div>

            <div x-show="dash.modes.length === 0">
                {{ __('No hay modos ganadores actualmente') }}.
                <br>
                {{ __('Seleccione otro tipo de bingo') }}.
            </div>

            {{-- Cantidad de cartones --}}
            <div>
                <label class="mb-3 block text-sm font-semibold text-indigo-100 text-left">
                    {{ __('Cantidad de cartones') }}
                </label>
                <div class="grid grid-cols-3 gap-3">
                    <template x-for="n in [1,2,3]" :key="n">
                        <button type="button"
                                @click="config.count_cartons = n"
                                :class="config.count_cartons === n
                                    ? 'bg-fuchsia-500 border-fuchsia-400 shadow-lg shadow-fuchsia-900/40'
                                    : 'bg-white/5 border-white/15 hover:bg-white/10'"
                                class="rounded-xl border-2 py-3 text-lg font-bold transition">
                            <span x-text="n"></span>
                        </button>
                    </template>
                </div>
            </div>

            <div>
                <label class="mb-3 block text-sm font-semibold text-indigo-100 text-left">
                    {{ __('Selección automática') }}
                </label>
                <div class="grid grid-cols-2 gap-3">
                    <template x-for="option in [{label: 'Si', value: true}, {label: 'No', value: false}]" :key="'auto-selection-' + option.label">
                        <button type="button"
                                @click="config.auto_selection = option.value"
                                :class="config.auto_selection === option.value
                                    ? 'bg-fuchsia-500 border-fuchsia-400 shadow-lg shadow-fuchsia-900/40'
                                    : 'bg-white/5 border-white/15 hover:bg-white/10'"
                                class="rounded-xl border-2 px-4 py-3 text-sm font-bold transition">
                            <span x-text="option.label"></span>
                        </button>
                    </template>
                </div>
            </div>

            <div>
                <label class="mb-3 block text-sm font-semibold text-indigo-100 text-left">
                    {{ __('Series automáticas') }}
                </label>
                <div class="grid grid-cols-2 gap-3">
                    <template x-for="option in [{label: 'Si', value: true}, {label: 'No', value: false}]" :key="'auto-series-' + option.label">
                        <button type="button"
                                @click="config.auto_series = option.value"
                                :class="config.auto_series === option.value
                                    ? 'bg-fuchsia-500 border-fuchsia-400 shadow-lg shadow-fuchsia-900/40'
                                    : 'bg-white/5 border-white/15 hover:bg-white/10'"
                                class="rounded-xl border-2 px-4 py-3 text-sm font-bold transition">
                            <span x-text="option.label"></span>
                        </button>
                    </template>
                </div>
            </div>

            {{-- Botón Iniciar Juego --}}
            <button type="submit"
                    x-bind:disabled="!ready()" x-on:click="getStart()"
                    :class="!ready() ? 'opacity-50 cursor-not-allowed' : 'hover:bg-fuchsia-400 hover:-translate-y-0.5'"
                    class="group flex w-full items-center justify-center gap-2 rounded-2xl bg-fuchsia-500 px-8 py-4 text-lg font-bold text-white shadow-xl shadow-fuchsia-900/40 transition active:translate-y-0 focus:outline-none focus:ring-4 focus:ring-fuchsia-300/50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M8 5v14l11-7L8 5z"/>
                </svg>
                Iniciar Juego
            </button>

            <p x-show="ready()" class="text-center text-xs text-fuchsia-200/80 -mt-4">
                Configure un modo de juego para continuar.
            </p>
        </form>

    </div>

    <x-slot name="scripts">

        <script>

            const ConfigSimulator = () => {
                return {
                    dash: {
                        contexts: [],
                        modes: [],
                        submodes: [],
                        cartons: [],
                    },
                    storage: null,
                    cookie: null,
                    progress: {
                        status: 0,
                        process: 'Loading game ...',
                    },
                    config: {
                        context: 1,
                        mode: { id: 0, name: '' },
                        submodes: [],
                        count_cartons: 0,
                        auto_series: false,
                        auto_selection: false
                    },
                    continueGame(){
                        location.href = "/simulator/game?_st="+this.storage;
                    },
                    newGame(){

                        fetch(
                            "{{ route('simulator.forget') }}", 
                            { 
                                method: "POST", 
                                headers: {
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({storage: this.storage})
                            }
                        ).then( res => res.json())
                        .then(sync => { 
                            // console.log("forget",sync);
                            localStorage.removeItem(sync.local);
                            this.storage = sync.conf;
                        });
                    },
                    checktype(type, data){
                        return ( (typeof data) == type && data !== 'undefined' );
                    },
                    form: function(){

                        // localStorage.setItem(3,'uno');
                        this.storage = localStorage.getItem('simulator');
                        this.storage = ( this.checktype('string',this.storage) ? this.storage : null );

                        this.getModes();

                        fetch(
                            "{{ route('simulator.storage') }}", 
                            { 
                                method: "POST", 
                                headers: {
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify({storage: this.storage})
                            }
                        )
                        .then( res => res.json())
                        .then( sync => {
                            // console.log("sync",sync);
                            // console.log("len",Object.values(sync)[1]);
                            if(sync.conf != null){ // Object.entries(sync.data.conf).length
                                localStorage.setItem(sync.local,sync.conf);
                                this.storage = localStorage.getItem(sync.local);
                            }
                        });

                        
                        // console.log("context-fetch");
                        fetch("{{ route('contexts') }}")
                            .then(res => res.json())
                            .then(data => { 
                                this.dash.contexts = data;
                            }
                        );

                        // Depends on the context slected
                        // fetch("{{ route('modes') }}")
                        //     .then(res => res.json())
                        //     .then(data => { 
                        //         this.dash.modes = data;
                        //     }
                        // );
                    },
                    getModes: function(context = null){

                        if( !isNaN( parseInt( context ) ) ) this.config.context = context;
                        this.dash.submodes = [];
                        // Get Modes Depends on context change selected
                        fetch("/api/modes/"+this.config.context)
                            .then(res => res.json())
                            .then(data => { 
                                this.dash.modes = data;
                            }
                        );
                    },
                    getSubmodes: function(event, mode_id = null, mode_name = null){
                        // Get Modes Depends on mode change selected
                        if( !isNaN( parseInt( mode_id ) ) ) this.config.mode.id = mode_id;
                        this.dash.submodes = this.config.submodes = [];
                        fetch("/api/submodes/"+this.config.mode.id)
                            .then(res => res.json())
                            .then(data => { 
                                this.dash.submodes = data;
                                if(event) this.config.mode.name = event.target.options[event.target.options.selectedIndex].innerText;
                                if(mode_name != null) this.config.mode.name = mode_name;
                            }
                        );
                    },
                    setSubmodes: function(submode_id = null, remove = false){
                        // Config dash.submodes --> config.submodes
                        // console.log("param_submode_id",submode_id);
                        // if( this.config.submodes.length ){
                            const findSubmode = this.config.submodes.find(sub => sub.submode_id === submode_id);

                            if(!findSubmode && !remove){
                                // No Existe, Se agrega
                                this.config.submodes.push(
                                    this.dash.submodes.find(submode => submode.submode_id === submode_id)
                                );
                            }

                            if( findSubmode && remove ){
                                // Existe, se quita 
                                this.config.submodes = this.config.submodes.filter(submode => submode.submode_id !== submode_id);
                            }

                        // }
                    },
                    ready: function(){
                        return (
                            this.config.context > 0 && 
                            this.config.mode.id > 0 && 
                            this.config.submodes.length > 0 && 
                            this.config.count_cartons > 0 
                            // this.config.auto_selection > 0 && 
                            // this.config.auto_series > 0 
                        );
                    },
                    getStart: function(){
                        this.progress.status == 0;
                        if(this.ready()){
                            
                            fetch(
                                "{{ route('simulator.start') }}", 
                                { 
                                    method: "POST", 
                                    headers: {
                                        'Accept': 'application/json',
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                    },
                                    body: JSON.stringify( this.config )
                                }
                            )
                            .then( res => res.json())
                            .then( sync => {
                                // console.log("start",sync);
                                if(sync.conf != null) // Object.entries(sync.data.conf).length
                                    localStorage.setItem(sync.local,sync.conf);

                                if(localStorage.getItem(sync.local))
                                    this.storage = localStorage.getItem(sync.local);                              

                            });

                            const progress = setInterval(() => {
                                if( this.progress.status <= 100 )
                                    this.progress.status++;
                                else{
                                    clearInterval(progress);
                                    this.progress.status = 0;
                                    location.href = "/simulator/game?_st="+this.storage;
                                }
                            }, 30);
                        }
                    },
                    namespaced: true,
                    sound: {
                        serie: '', // Audio dinamico de cada serie del juego en curso
                        start: 'start_male.mp3', // Mensaje al iniciar un juego
                        win: '' // Mansaje resultado ganador/perdedor
                    },
                    game: {
                        status: false, // Estado de un juego
                        start: false, // Inicia un juego
                        pause: false, // Pausa el juego en curso
                        round: false, // Habilita la bola de bingo
                        countCartons: 0, // Cantidad de cartones en juego
                        numberscartons: [], // Numero de cartones
                        cartons: [], // Coordenadas de cartones en juego
                        structureCarton: [
                            // Structure´s Example
                            // {
                            //     carton: '',
                            //     series: [
                            //         {
                            //             letter: '',
                            //             numbers: [
                            //                 { number: 0, active: false, coordinate: '' }
                            //             ]
                            //         },
                            //     ]
                            // }
                        ],
                        market: [
                            // Structure´s table
                            {
                                letter: 'B',
                                range: [
                                    { number: 1, active: false },
                                    { number: 2, active: false },
                                    { number: 3, active: false },
                                    { number: 4, active: false },
                                    { number: 5, active: false },
                                    { number: 6, active: false },
                                    { number: 7, active: false },
                                    { number: 8, active: false },
                                    { number: 9, active: false },
                                    { number: 10, active: false },
                                    { number: 11, active: false },
                                    { number: 12, active: false },
                                    { number: 13, active: false },
                                    { number: 14, active: false },
                                    { number: 15, active: false }
                                ]
                            },
                            {
                                letter: 'I',
                                range: [
                                    { number: 16, active: false },
                                    { number: 17, active: false },
                                    { number: 18, active: false },
                                    { number: 19, active: false },
                                    { number: 20, active: false },
                                    { number: 21, active: false },
                                    { number: 22, active: false },
                                    { number: 23, active: false },
                                    { number: 24, active: false },
                                    { number: 25, active: false },
                                    { number: 26, active: false },
                                    { number: 27, active: false },
                                    { number: 28, active: false },
                                    { number: 29, active: false },
                                    { number: 30, active: false }
                                ]
                            },
                            {
                                letter: 'N',
                                range: [
                                    { number: 31, active: false },
                                    { number: 32, active: false },
                                    { number: 33, active: false },
                                    { number: 34, active: false },
                                    { number: 35, active: false },
                                    { number: 36, active: false },
                                    { number: 37, active: false },
                                    { number: 38, active: false },
                                    { number: 39, active: false },
                                    { number: 40, active: false },
                                    { number: 41, active: false },
                                    { number: 42, active: false },
                                    { number: 43, active: false },
                                    { number: 44, active: false },
                                    { number: 45, active: false }
                                ]
                            },
                            {
                                letter: 'G',
                                range: [
                                    { number: 46, active: false },
                                    { number: 47, active: false },
                                    { number: 48, active: false },
                                    { number: 49, active: false },
                                    { number: 50, active: false },
                                    { number: 51, active: false },
                                    { number: 52, active: false },
                                    { number: 53, active: false },
                                    { number: 54, active: false },
                                    { number: 55, active: false },
                                    { number: 56, active: false },
                                    { number: 57, active: false },
                                    { number: 58, active: false },
                                    { number: 59, active: false },
                                    { number: 60, active: false }
                                ]
                            },
                            {
                                letter: 'O',
                                range: [
                                    { number: 61, active: false },
                                    { number: 62, active: false },
                                    { number: 63, active: false },
                                    { number: 64, active: false },
                                    { number: 65, active: false },
                                    { number: 66, active: false },
                                    { number: 67, active: false },
                                    { number: 68, active: false },
                                    { number: 69, active: false },
                                    { number: 70, active: false },
                                    { number: 71, active: false },
                                    { number: 72, active: false },
                                    { number: 73, active: false },
                                    { number: 74, active: false },
                                    { number: 75, active: false }
                                ]
                            }
                        ],
                        autoSelect: 'No',
                        autoRound: 'No',
                        mode: {
                            type: '',
                            coordinates: []
                        }, // Coordenadas del modo de bingo ganador (Nombre/Coordenadas)
                        hours: '00', // Horas de duración del juego
                        minutes: '00', // Minutos de duración del juego
                        seconds: '00', // Segundos de duración del juego
                        time: null, // Estado del tiempo (Temporizador)
                        serie: '', // Serie actual de juego en curso
                        sequence: [], // Secuencia ordenada de series que han salido durante un juego
                        seriesPlayer: [], // Series en las que el jugador ha dado clic en el carton
                        coordinatesActive: [], // coordenadas en las que el jugador ha dado clic en el carton concatenado con _ con la serie
                        result: [], // Arreglo de resultados
                        final: null, // Resultado final ganador o perdedor
                        countWinner: 0 // Resultado final ganador o perdedor
                    },
                    table: [
                        { letter: 'B', range: [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15] },
                        { letter: 'I', range: [16, 17, 18, 19, 20, 21, 22, 23, 24, 25, 26, 27, 28, 29, 30] },
                        { letter: 'N', range: [31, 32, 33, 34, 35, 36, 37, 38, 39, 40, 41, 42, 43, 44, 45] },
                        { letter: 'G', range: [46, 47, 48, 49, 50, 51, 52, 53, 54, 55, 56, 57, 58, 59, 60] },
                        { letter: 'O', range: [61, 62, 63, 64, 65, 66, 67, 68, 69, 70, 71, 72, 73, 74, 75] }
                    ], // Información del tablero de marcación
                    coordinatesNatives: [
                        ['5A', '4A', '3A', '2A', '1A'],
                        ['5B', '4B', '3B', '2B', '1B'],
                        ['5C', '4C', '3C', '2C', '1C'],
                        ['5D', '4D', '3D', '2D', '1D'],
                        ['5E', '4E', '3E', '2E', '1E']
                    ], // Coordenadas obligatorias de cada carton
                    modes_old: [
                        {
                            type: 'Letra A',
                            coordinates: [
                                ['5A', '4A', '3A', '2A', '1A', '5B', '3B', '5C', '3C', '5D', '3D', '5E', '4E', '3E', '2E', '1E']
                            ]
                        },
                        {
                            type: 'Lleno',
                            coordinates: [
                                ['5A', '4A', '3A', '2A', '1A', '5B', '4B', '3B', '2B', '1B', '5C', '4C', '3C', '2C', '1C', '5D', '4D', '3D', '2D', '1D', '5E', '4E', '3E', '2E', '1E']
                            ]
                        },
                        {
                            type: 'Lineal Horizontal',
                            coordinates: [
                                ['5A', '5B', '5C', '5D', '5E'],
                                ['4A', '4B', '4C', '4D', '4E'],
                                ['3A', '3B', '3C', '3D', '3E'],
                                ['2A', '2B', '2C', '2D', '2E'],
                                ['1A', '1B', '1C', '1D', '1E']
                            ]
                        },
                        {
                            type: 'Lineal vertical',
                            coordinates: [
                                ['1A', '2A', '3A', '4A', '5A'],
                                ['1B', '2B', '3B', '4B', '5B'],
                                ['1C', '2C', '3C', '4C', '5C'],
                                ['1D', '2D', '3D', '4D', '5D'],
                                ['1E', '2E', '3E', '4E', '5E']
                            ]
                        },
                        {
                            type: 'Linea Diagonal',
                            coordinates: [
                                ['1A', '2B', '3C', '4D', '5E'],
                                ['5A', '4B', '3C', '2D', '1E']
                            ]
                        }
                    ] // Formas de juego (Figuras de bingo ganadores)
                }
            }

        </script>


    </x-slot>

</x-guest-layout>
