<div :id="'carton_'+number" 
    class="w-[200px] md:w-[200px] h-[220px] md:h-[320px] m-1 rounded-2xl border border-white/10 bg-indigo-950/40 p-2 sm:p-4 self-center flex flex-row justify-between relative">

    

    <div class="absolute top-1 left-1/2 transform -translate-x-1/2 p-1 text-center font-bold rounded-sm text-fuchsia-200 text-xs" x-text="'Carton&nbsp;#'+number"></div>
    

    <template x-for="(series, letter) in carton">
        <div class="rounded-lg flex flex-col justify-between mt-8">
            <div class="font-bold text-white text-center text-[12px] md:text-[14px]" x-text="letter"></div>

            <template x-for="(serie, key) in series">
                @if( $selectable )
                    <div class="flex aspect-square items-center justify-center rounded-md text-xs font-bold transition duration-500 p-1.5 sm:text-sm cursor-pointer" x-on:click="toggleSerie(number, letter, key)" :class="cartons[number][letter][key].active || serie['number'] == 0 ? 'bg-fuchsia-500 text-white' : 'bg-white/5 text-indigo-100/80'">
                        <p x-text="serie['number']" class="inline-block" :class="serie['number'] == 0 ? 'invisible' : ''"></p>
                    </div>
                @else
                    <div class="flex aspect-square items-center justify-center rounded-md text-xs font-bold transition duration-500 p-1.5 sm:text-sm cursor-pointer"   
                        :class="cartons[number][letter][key].active || serie['number'] == 0 ? 'bg-fuchsia-500 text-white' : 'bg-white/5 text-indigo-100/80'">
                        <p x-text="serie['number']" class="inline-block" :class="serie['number'] == 0 ? 'invisible' : ''"></p>
                    </div>
                @endif
            </template>
        </div>
    </template>

</div>
