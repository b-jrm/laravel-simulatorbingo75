<div class="w-[180px] md:w-[180px] h-auto p-2 bg-[#A12929] m-1 rounded-lg md:rounded-sm self-center flex flex-row justify-center shadow-[2px_1px_1px_1px_#ccc] relative m-1 scale-75 animate-beats cursor-pointer">

    <div class="absolute top-1 left-1/2 transform -translate-x-1/2 p-1 bg-white text-black text-[12px] md:text-[14px] text-center font-bold rounded-sm" x-text="win['carton']">
    </div>

    <template x-for="(series, letter) in cartons[win['carton']]">
        <div class="rounded-lg flex flex-col justify-center mt-8">
            <div class="font-bold text-white text-center text-[12px] md:text-[14px]" x-text="letter"></div>
            <template x-for="(serie, key) in series">
                <div class="rounded-sm md:rounded-lg flex items-center justify-center font-bold md:font-normal text-white text-[8px] md:text-[10px] transition-all duration-500 m-1 p-1 text-gray-800 min-w-[5px] min-h-[5px]" :class="win['coords'].findIndex( coord => coord.x === cartons[win['carton']][letter][key].coord.x && coord.y === cartons[win['carton']][letter][key].coord.y ) > -1 || serie['number'] == 0 ? 'bg-green-800 bg-opacity-75' : 'bg-[#C18C1A]'">
                    <p class="inline-block" :class="serie['number'] == 0 ? 'invisible' : ''" x-text="serie['number']"></p>
                </div>
            </template>
        </div>
    </template>

</div>
