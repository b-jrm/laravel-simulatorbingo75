<div id="carton_{{ $number }}" 
    class="w-[200px] md:w-[200px] h-[220px] md:h-[320px] p-2 bg-[#A12929] m-1 rounded-lg md:rounded-sm self-center flex flex-row justify-between shadow-[2px_1px_1px_1px_#ccc] relative m-3">
    @php $cols = 0; @endphp
    @foreach($carton as $letter => $series)

        @if(!$cols)
            <div class="absolute top-1 left-1/2 transform -translate-x-1/2 p-1 bg-white text-black-700 text-[12px] md:text-[14px] text-center font-bold rounded-sm">{{ $number }}
            </div>
        @endif
    
        <div class="rounded-lg flex flex-col justify-between mt-8">
            <div class="font-bold text-white text-center text-[12px] md:text-[14px]">{{ $letter }}</div>
            @foreach($series as $key => $serie)

                @if( $selectable )
                    <div class="bg-[#C18C1A] rounded-sm md:rounded-lg flex items-center justify-center font-bold md:font-normal text-white text-[10px] md:text-[14px] transition-all duration-500 m-1 p-1 text-gray-800 cursor-pointer min-w-[10px] min-h-[10px]" x-on:click="toggleSerie('{{ $number }}', '{{ $letter }}', {{ $key }})" :class="( (cartons['{{ $number }}']['{{ $letter }}'][{{ $key }}].active || {{ $serie['number'] }} == 0) ? 'bg-gray-800 bg-opacity-75' : 'bg-[#C18C1A]')">
                        <p 
                            class="inline-block {{ (($serie['number'] == 0) ? 'invisible' : '') }}"
                        >{{ $serie['number'] }}</p>
                    </div>
                @else
                    <div class="{{ (($serie['number'] == 0) ? 'bg-gray-800 bg-opacity-75' : 'bg-[#C18C1A]') }} rounded-sm md:rounded-lg flex items-center justify-center font-bold md:font-normal text-white text-[10px] md:text-[14px] transition-all duration-500 m-1 p-1 text-gray-800 min-w-[10px] min-h-[10px]">
                        <p 
                            class="inline-block {{ (($serie['number'] == 0) ? 'invisible' : '') }}"
                        >{{ $serie['number'] }}</p>
                    </div>
                @endif
                    
            @endforeach
        </div>                                
        @php $cols++ @endphp

    @endforeach
</div>

<x-slot name="styles">
    <style>
        .active_serie{
            background-color: green;
        }
    </style>
</x-slot>

<x-slot name="scripts">
    <script>
        
    </script>
</x-slot>