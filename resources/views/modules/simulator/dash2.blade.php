<x-guest-layout>

    <div x-data="ConfigSimulator()" x-init="form()" class="w-full relative grid grid-cols-1 gap-4 p-6 bg-[#610720] from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 shadow-2xl shadow-gray-500/20 dark:shadow-none transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500 overflow-hidden min-h-screen text-[20px]">
        
        <div class="w-full h-full absolute top-0 left-0 bg-[#4c0519] flex flex-col items-center justify-center text-[15px] text-white font-thin z-10" x-show="storage !== null">
            <p class="text-[25px] text-white m-3">Tienes una partida pendiente</p>
            <div class="grid grid-cols-2 gap-3">
                <button type="button" class="p-2 border border-white md:border-black bg-transparent text-white md:text-black rounded-md font-bold hover:text-white hover:border-white" x-on:click="continueGame()">Continuar partida</button>
                <button type="button" class="p-2 border border-black bg-transparent text-black rounded-md font-black hover:text-white hover:border-white" x-on:click="newGame()">Nueva partida</button>
            </div>
            
        </div>
    
        <h3 class="font-bold text-center text-white pb-1 border-b">SIMULADOR DE BINGO 75</h3>

        <div class="w-full h-full absolute top-0 left-0 bg-[#4c0519] bg-opacity-80 flex flex-col items-center justify-center text-[15px] text-white font-thin z-10" x-show="progress.status > 0 && progress.status < 100">
            
            <!-- <svg aria-hidden="true" role="status" class="inline w-4 h-4 mr-3 text-purple animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/>
            </svg> -->
            
            <div class="mb-1 text-base font-medium text-purple-700 dark:text-white text-left flex flex-row flex-nowrap w-3/5 pl-1">
                <p>&#10140;</p>&nbsp;<p class="text-[14px] font-thin" x-text="progress.process">Loading ...</p>
            </div>
            <div class="w-3/5 bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                <div class="bg-white h-2.5 rounded-full dark:bg-white" x-bind:style="'width: '+progress.status+'%'"></div>
            </div>
            
        </div>

        <div class="flex flex-col items-start justify-center text-white font-thin border-b pb-4">
            <small class="text-[13px] uppercase">
                Juego:&nbsp;
                <span class="inline-block tooltip tooltip-top tooltip-warning lowercase" data-tip="Disponible de 75 bolas&#10;">
                    <svg name="info" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path fill="currentColor" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8Zm8-6.5a6.5 6.5 0 1 0 0 13a6.5 6.5 0 0 0 0-13ZM6.5 7.75A.75.75 0 0 1 7.25 7h1a.75.75 0 0 1 .75.75v2.75h.25a.75.75 0 0 1 0 1.5h-2a.75.75 0 0 1 0-1.5h.25v-2h-.25a.75.75 0 0 1-.75-.75ZM8 6a1 1 0 1 1 0-2a1 1 0 0 1 0 2Z"/></svg>
                </span>
            </small>
            <select class="w-full rounded-lg leading-2 text-black ring-offset-2 ring-2 focus:ring-offset-2 focus:ring-2" 
                x-model="config.context"
                x-on:change="getModes()"
                disabled>
                <option value="0" selected>...</option>
                <template x-for="context in dash.contexts">
                    <option :value="context.context_id" x-text="context.name" x-bind:selected="context.context_id == 1"></option>
                </template>
            </select>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

            
            <div class="flex flex-col items-start justify-center text-white font-thin pb-4 md:col-span-2">
                <small class="text-[13px] uppercase">
                    Bingos&nbsp;ganadores&nbsp;
                    <span class="inline-block tooltip tooltip-top tooltip-warning lowercase" data-tip="Seleccione las formas ganadoras de bingo&#10;">
                        <svg name="info" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path fill="currentColor" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8Zm8-6.5a6.5 6.5 0 1 0 0 13a6.5 6.5 0 0 0 0-13ZM6.5 7.75A.75.75 0 0 1 7.25 7h1a.75.75 0 0 1 .75.75v2.75h.25a.75.75 0 0 1 0 1.5h-2a.75.75 0 0 1 0-1.5h.25v-2h-.25a.75.75 0 0 1-.75-.75ZM8 6a1 1 0 1 1 0-2a1 1 0 0 1 0 2Z"/></svg>
                    </span>
                </small>
                <select class="w-full rounded-lg leading-2 text-black ring-offset-2 ring-2 focus:ring-offset-2 focus:ring-2" 
                    x-model="config.mode.id"
                    x-on:change="getSubmodes"
                >
                    <option value="" selected>...</option>
                    <template x-for="mode in dash.modes">
                        <option :value="mode.mode_id" x-text="mode.name"></option>
                    </template>
                </select>
            </div>

            <!-- <div class="flex flex-col items-start justify-center text-white font-thin pb-4 md:col-span-2 lg:col-span-4" x-model="config.submode">
                <small class="text-[13px]">Subforma ganadora</small>
                <select class="w-full rounded-lg leading-2 text-black ring-offset-2 ring-2 focus:ring-offset-2 focus:ring-2">
                    <option value="" selected>...</option>
                    <template x-for="submode in dash.submodes">
                        <option :value="submode.submode_id" x-text="submode.name"></option>
                    </template>
                </select>
            </div> -->

            <div class="flex flex-row items-start text-white font-thin pb-4 col-span-1 md:col-span-2 lg:col-span-4 p-4 text-center overflow-x-auto border border-yellow border-b-0 bg-gray-200 bg-opacity-20" x-show="config.submodes.length">
                <!-- <Objetive v-bind:types="game.mode"></Objetive> -->
                <!-- <p>Modos Ganadores Seleccionados</p> -->
                <template x-for="submode in config.submodes">
                    <div class="flex flex-col items-center mx-3">
                        <!-- <p class="block text-center text-white text-[12px]" x-text="submode.name"></p> -->
                        <div class="w-[80px] h-[80px] bg-gray-400 rounded-md p-1 flex flex-row items-center justify-center">

                            <template x-for="col in submode.columns">
                                <div class="flex flex-col items-center justify-center">

                                    <template x-for="row in submode.rows">

                                        <div :class="(submode.coordinates.findIndex(coord => coord.x == (col-1) && coord.y == (row-1) ) > -1) ? 'bg-gray-800' : 'bg-gray-100'" class="p-[5px] mb-1 mr-1 rounded-sm"></div>
                                        
                                    </template>

                                </div>
                            </template>
                            
                        </div>
                    </div>
                </template>
                
            </div>

            <div class="flex flex-col items-start justify-center text-white font-thin pb-4 md:col-span-2">
                <small class="uppercase">
                    Cantidad&nbsp;de&nbsp;cartones&nbsp;
                    <span class="inline-block tooltip tooltip-top tooltip-warning lowercase" data-tip="¿Con cuantos cartones jugará?&#10;">
                        <svg name="info" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path fill="currentColor" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8Zm8-6.5a6.5 6.5 0 1 0 0 13a6.5 6.5 0 0 0 0-13ZM6.5 7.75A.75.75 0 0 1 7.25 7h1a.75.75 0 0 1 .75.75v2.75h.25a.75.75 0 0 1 0 1.5h-2a.75.75 0 0 1 0-1.5h.25v-2h-.25a.75.75 0 0 1-.75-.75ZM8 6a1 1 0 1 1 0-2a1 1 0 0 1 0 2Z"/></svg>
                    </span>
                </small>
                <select class="w-full rounded-lg leading-2 text-black ring-offset-2 ring-2 focus:ring-offset-2 focus:ring-2" 
                    x-model="config.count_cartons"
                >
                    <option value="0" selected>...</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                </select>
            </div>

            <div class="flex flex-col items-start justify-center text-white font-thin pb-4">
                <small class="uppercase">¿Selección automática?&nbsp;
                    <span class="inline-block tooltip tooltip-top tooltip-warning lowercase" data-tip="Proximamente disponible&#10;">
                        <svg name="info" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path fill="currentColor" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8Zm8-6.5a6.5 6.5 0 1 0 0 13a6.5 6.5 0 0 0 0-13ZM6.5 7.75A.75.75 0 0 1 7.25 7h1a.75.75 0 0 1 .75.75v2.75h.25a.75.75 0 0 1 0 1.5h-2a.75.75 0 0 1 0-1.5h.25v-2h-.25a.75.75 0 0 1-.75-.75ZM8 6a1 1 0 1 1 0-2a1 1 0 0 1 0 2Z"/></svg>
                    </span>
                </small>
                <select class="w-full rounded-lg leading-2 text-black ring-offset-2 ring-2 focus:ring-offset-2 focus:ring-2" disabled>
                    <option value="">...</option>
                    <option value="No" title="Tu mism@ seleccionas las coincidencias en tu/s carton/es" selected>No</option>
                    <option value="Si" title="Las coincidencias de bingo se seleccionarán automáticamente">Si</option>
                </select>
            </div>

            <div class="flex flex-col items-start justify-center text-white font-thin pb-4">
                <small class="uppercase">¿Series automáticas?&nbsp;
                    <span class="inline-block tooltip tooltip-top tooltip-warning lowercase" data-tip="Proximamente disponible&#10;">
                        <svg name="info" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path fill="currentColor" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8Zm8-6.5a6.5 6.5 0 1 0 0 13a6.5 6.5 0 0 0 0-13ZM6.5 7.75A.75.75 0 0 1 7.25 7h1a.75.75 0 0 1 .75.75v2.75h.25a.75.75 0 0 1 0 1.5h-2a.75.75 0 0 1 0-1.5h.25v-2h-.25a.75.75 0 0 1-.75-.75ZM8 6a1 1 0 1 1 0-2a1 1 0 0 1 0 2Z"/></svg>
                    </span>
                </small>
                <select class="w-full rounded-lg leading-2 text-black ring-offset-2 ring-2 focus:ring-offset-2 focus:ring-2" disabled>
                    <option value="">...</option>
                    <option value="No" title="Tendrás un boton para lanzar la proxima serie cuando desees" selected>No</option>
                    <option value="Si" title="La series aparecerán automáticamente cada n segundos">Si</option>
                </select>
            </div>

            <div class="flex flex-row items-center justify-center text-white font-thin p-4 md:col-span-2">
                <!-- <a href="{{ route('home') }}" class="border py-2 px-4 rounded-md hover:bg-white hover:text-black active:bg-white active:text-black mx-2" disabled>{{ __('Cancel') }}</a> -->
                <button :class="ready() ? 'opacity-100 cursor-pointer' : 'opacity-25 cursor-not-allowed'" class="border py-2 px-4 rounded-md hover:bg-white hover:text-black active:bg-white active:text-black mx-2" x-bind:disabled="!ready()" x-on:click="getStart()">{{ __('Start') }}</button>
            </div>

        </div>
        
    </div>

    <x-slot name="scripts">

        <script>

            const ConfigSimulator = () => {
                return {
                    dash: {
                        contexts: [],
                        modes: [],
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
                    getModes: function(){
                        this.config.submodes = [];
                        // Get Modes Depends on context change selected
                        fetch("/api/modes/"+this.config.context)
                            .then(res => res.json())
                            .then(data => { 
                                this.dash.modes = data;
                            }
                        );
                    },
                    getSubmodes: function(event){
                        // Get Modes Depends on mode change selected
                        this.config.submodes = [];
                        fetch("/api/submodes/"+this.config.mode.id)
                            .then(res => res.json())
                            .then(data => { 
                                this.config.submodes = data;
                                this.config.mode.name = event.target.options[event.target.options.selectedIndex].innerText;
                            }
                        );
                    },
                    ready: function(){
                        return (
                            this.config.context > 0 && 
                            this.config.mode.id > 0 && 
                            this.config.submodes.length > 0 && 
                            this.config.count_cartons > 0
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
                            }, 10);
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
