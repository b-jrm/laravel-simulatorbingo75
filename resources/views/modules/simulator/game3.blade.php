<x-guest-layout>

    <div x-data="Simulator" x-init="start(); setTimeout(() => { moveScroll(0,9999,'#sequences') },1000);" class="border rounded-lg bg-white overflow-hidden flex flex-col relative">

        <template x-if="sequence.length == 0">
            <audio id="start" x-bind:src="'{{ asset('storage/sounds') }}/'+config.sound.start.audio" autoplay></audio>
        </template>

        <template x-if="config.sound.serie.audio !== ''">
            <audio id="serie" x-bind:src="'{{ asset('storage/sounds') }}/'+config.sound.serie.audio+'.mp3'" autoplay></audio>
        </template>

        <template x-if="config.sound.bolillero.audio !== ''">
            <audio id="bolillero" x-bind:src="'{{ asset('storage/sounds') }}/'+config.sound.bolillero.audio" class="hidden" autoplay loop controls x-bind:volume="config.sound.bolillero.volume"></audio>
        </template>

        <template x-if="config.sound.shot.audio !== ''">
            <audio id="shot" x-bind:src="'{{ asset('storage/sounds') }}/'+config.sound.shot.audio" autoplay></audio>
        </template>

        <template x-if="config.checking.status && config.checking.wins.length < 1">
            <div class="w-full h-full absolute top-0 bottom-0 left-0 right-0 z-20 flex flex-col justify-center items-center bg-gray-500 bg-opacity-70">

                <audio id="win" x-bind:src="'{{ asset('storage/sounds') }}/'+config.sound.win.audio" autoplay></audio>

                <template x-if="Object.keys(cartons).length > 1">
                    <div class="w-full md:w-2/5 rounded-t-full p-6 bg-[#610720] text-white text-center text-[30px] font-bold">
                        <h3 x-text="'No hay bingo!'"></h3>
                    </div>
                </template>
                <template x-if="Object.keys(cartons).length <= 1">
                    <div class="w-full md:w-2/5 rounded-t-full p-6 bg-[#610720] text-white text-center text-[30px] font-bold">
                        <h3 x-text="'Tu carton no tiene bingo!'"></h3>
                    </div>
                </template>
                <div class="w-full md:w-2/5 rounded-b-full pb-6 bg-white text-yellow-600 text-center text-[30px] font-bold">
                    <button type="button" class="w-2/5 p-4 bg-orange-600 text-center text-white font-bold rounded-b-full overflow-hidden cursor-pointer active:ring-0 active:outline-0" x-on:click="config.checking.status = false">{{ __('Continuar Juego') }}</button>
                </div>
            </div>
        </template>

        <template x-if="config.checking.status && config.checking.wins.length > 0">
            <div class="w-full h-full absolute top-0 left-0 z-20 flex flex-col justify-center items-center bg-white bg-opacity-70 p-6">
                
                <audio id="win" x-bind:src="'{{ asset('storage/sounds') }}/'+config.sound.win.audio" autoplay></audio>

                <div class="w-full md:w-2/5 rounded-t-full p-6 bg-[#610720] text-white text-center text-[20px] font-bold border-4 border-yellow-800 border-b-0">
                    <h3 x-text="'Has ganado!'"></h3>
                </div>

                <div class="w-full md:w-2/5 p-6 bg-[#610720] bg-opacity-50 text-white text-center text-[15px] font-bold flex flex-row overflow-x-auto snap-center border-4 border-yellow-800 border-b-0 border-t-0">
                    <template x-for="win in config.checking.wins">
                        <x-carton-win/>
                    </template>
                </div>

                <div class="w-full md:w-2/5 rounded-b-full p-0 bg-[#610720] text-white text-center text-[20px] font-bold grid grid-cols-2 border-4 border-yellow-800 border-t-0">


                    <button type="button" class="p-2 bg-transparent border-r text-center text-white font-bold overflow-hidden cursor-pointer active:ring-0 active:outline-0" x-on:click="save">{{ __('Guardar') }}</button>

                    <button type="button" class="p-2 bg-transparent border-l text-center text-white font-bold overflow-hidden cursor-pointer active:ring-0 active:outline-0" x-on:click="finish">{{ __('Salir') }}</button>
                </div>

                
            </div>
        </template>

        <section class="px-6 bg-[#610720] flex flex-row flex-nowrap items-center justify-between text-white text-[25px]">
            <h4>{{ __('Bingo 75') }}</h4>
            <div class="cursor-pointer p-4 flex justify-center items-center text-white" x-on:click="config.open = !config.open">
                <svg name="config" class="w-[30px] w-[30px]" xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="4" d="M41.5 10h-6m-8-4v8m0-4h-22m8 14h-8m16-4v8m22-4h-22m20 14h-6m-8-4v8m0-4h-22"/></svg>
            </div>
        </section>

        <!-- <p class="text-[25px] p-4" x-text="config.checking.wins.length"></p> -->


        <section class="w-full flex">
            
            <!-- CAROUSEL -->
            <div class="w-full relative p-2 pb-12 flex flex-row flex-nowrap items-center justify-center">
                <div class="bg-transparent focus:bg-gray-200 focus:bg-opacity-50 hover:bg-gray-200 hover:bg-opacity-50 text-black w-full flex justify-around items-center absolute bottom-0 left-0 z-10">

                    <div class="flex flex-row justify-center items-center">
                        
                        <a class="flex flex-nowrap items-center rounded-sm cursor-pointer px-1 mx-1 focus:tooltip focus:tooltip-top focus:tooltip-warning text-white" :class="config.section.submodes.extended ? 'bg-[#C18C1A]' : 'bg-[#610720]'" data-tip="{{ __('Winning ways') }}" x-on:click="toggleView('submodes')">
                            <svg class="w-[25px] h-[25px]" xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 28 28"><path fill="currentColor" d="M3 6.75A3.75 3.75 0 0 1 6.75 3H9.5v6.5H3V6.75ZM3 11v6h6.5v-6H3Zm0 7.5v2.75A3.75 3.75 0 0 0 6.75 25H9.5v-6.5H3Zm8 6.5h6v-6.5h-6V25Zm7.5 0h2.75A3.75 3.75 0 0 0 25 21.25V18.5h-6.5V25Zm6.5-8v-6h-6.5v6H25Zm0-7.5V6.75A3.75 3.75 0 0 0 21.25 3H18.5v6.5H25ZM17 3h-6v6.5h6V3Zm0 8v6h-6v-6h6Z"/></svg>
                            <p class="font-thin hidden md:inline-block">{{ __('Ways') }}</p>
                        </a>

                        <a class="flex flex-nowrap items-center rounded-sm cursor-pointer px-1 mx-1 focus:tooltip focus:tooltip-top focus:tooltip-warning text-white" :class="config.section.board.extended ? 'bg-[#C18C1A]' : 'bg-[#610720]'" data-tip="{{ __('View Board') }}" x-on:click="toggleView('board')">
                            <svg class="w-[25px] h-[25px]" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 256 256"><path fill="currentColor" d="M224 44H32a12 12 0 0 0-12 12v136a20 20 0 0 0 20 20h176a20 20 0 0 0 20-20V56a12 12 0 0 0-12-12ZM44 116h32v24H44Zm56 0h112v24H100Zm112-48v24H44V68ZM44 164h32v24H44Zm56 24v-24h112v24Z"/></svg>
                            <p class="font-thin hidden md:inline-block">{{ __('Board') }}</p>
                        </a>

                    </div>

                    <div class="flex justify-center items-center">
                        <a class="pl-4 cursor-pointer text-[#C18C1A]" x-on:click="moveScroll(0, -222, '.slider', true)">
                            <svg class="w-[30px] h-[30px]" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="M24 0v24H0V0h24ZM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018Zm.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01l-.184-.092Z"/><path fill="currentColor" d="M6 3a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3H6Zm7.707 6.879L11.586 12l2.121 2.121a1 1 0 0 1-1.414 1.415l-2.829-2.829a1 1 0 0 1 0-1.414l2.829-2.829a1 1 0 1 1 1.414 1.415Z"/></g></svg>
                        </a>
                        <a class="pr-4 cursor-pointer text-[#C18C1A]" x-on:click="moveScroll(0, 222, '.slider', true)">
                            <svg class="w-[30px] h-[30px]" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"><g fill="none" fill-rule="evenodd"><path d="M24 0v24H0V0h24ZM12.594 23.258l-.012.002l-.071.035l-.02.004l-.014-.004l-.071-.036c-.01-.003-.019 0-.024.006l-.004.01l-.017.428l.005.02l.01.013l.104.074l.015.004l.012-.004l.104-.074l.012-.016l.004-.017l-.017-.427c-.002-.01-.009-.017-.016-.018Zm.264-.113l-.014.002l-.184.093l-.01.01l-.003.011l.018.43l.005.012l.008.008l.201.092c.012.004.023 0 .029-.008l.004-.014l-.034-.614c-.003-.012-.01-.02-.02-.022Zm-.715.002a.023.023 0 0 0-.027.006l-.006.014l-.034.614c0 .012.007.02.017.024l.015-.002l.201-.093l.01-.008l.003-.011l.018-.43l-.003-.012l-.01-.01l-.184-.092Z"/><path fill="currentColor" d="M6 3a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h12a3 3 0 0 0 3-3V6a3 3 0 0 0-3-3H6Zm4.293 11.121L12.414 12l-2.121-2.121a1 1 0 1 1 1.414-1.415l2.829 2.829a1 1 0 0 1 0 1.414l-2.829 2.829a1 1 0 1 1-1.414-1.415Z"/></g></svg>
                        </a>
                    </div>

                    <button type="button" class="py-1 px-6 py-3 bg-[#610720] rounded text-center text-white font-bold overflow-hidden cursor-pointer active:ring-0 active:outline-0" x-on:click="bingo">{{ __('Bingo') }}</button>

                </div>

                <div class="w-full flex justify-center">
                    <div class="slider w-full flex flex-row flex-nowrap overflow-x-auto md:justify-center">
                        <template x-for="(carton, number) in cartons">
                            <div class="slider-item">
                                <x-carton2 :selectable="true"/>
                            </div>
                        </template>
                    </div>
                </div>

            </div>

        </section>

        <section class="p-2 flex flex-col">

            <template x-if="config.section.board.extended">
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
                                            <td :class="(range.active) ? 'bg-white text-black' : ''" class="border text-center" x-text="range.number"></td>
                                        </template>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </template>
                </article>
            </template>

            <template x-if="config.section.submodes.extended">
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

        </section>


        <!-- Bolillero -->
        <section class="p-2 grid grid-cols-1 md:grid-cols-2 gap-0">

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

                <div class="w-full flex flex-row items-center justify-center relative">
                    <div id="content-bounce" class="w-full h-full flex flex-row items-center justify-center p-0 px-12 md:p-3 md:px-12 overflow-x-auto">
                        <template x-if="sequence.length > 0">
                            <div class="ball-bounce w-[50px] min-w-[50px] min-h-[50px] h-[50px] rounded-full overflow-hidden flex items-center justify-center p-3 text-white font-thin m-2 last:scale-125 last:p-4 last:ml-12 last:font-bold" :class="sequence[sequence.length - 1].color"> <!-- :class="(round ? 'hidden w-[1px] h-[1px]' : '')" -->
                                <p class="flex items-center justify-center bg-white rounded-full text-black text-[12px] md:text-[14px] p-1">
                                    <b x-text="sequence[sequence.length - 1].letter+sequence[sequence.length - 1].number"></b>
                                </p>
                            </div>
                        </template>
                    </div>
                    <button type="button" class="w-auto p-6 bg-[#C18C1A] text-center text-white font-bold overflow-hidden cursor-pointer active:ring-0 active:outline-0 absolute left-0 top-0 bottom-0" :class="inRound ? 'cursor-not-allowed' : ''" x-on:click="setRound(); setTimeout(() => { moveScroll(0,9999,'#sequences') },1000)" :disabled="inRound">Lanzar</button>
                </div>

        </section>

    </div>

</x-guest-layout>