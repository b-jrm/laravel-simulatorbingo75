<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Bingo</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            transition-group{
                width: 100%;
                height: 100%;
            }
            .back-bingo{
                width: 250px;
                height: 320px;
                padding: 10px;
                background-color: #A12929;
                border-radius: 10px;
                align-self: center;
                display: flex;
                flex-flow: row;
                justify-content: space-between;
                box-shadow: 2px 1px 1px 1px #ccc;
                position: relative;
            }
            .column-bingo, .frame-title-bingo{
                border-radius: 10px;
                display: flex;
                flex-flow: column;
                justify-content: space-between;
            }
            .column-bingo{
                padding-top: 15px;
            }
            .frame-title-bingo{
                margin-left: auto;
                margin-right: auto;
                position: absolute;
                right: 0;
                left: 0;
                top: 0;
            }
            .min-frame{
                width: 30px;
                height: 30px;
                border-radius: 10px;
                background-color: #C18C1A;
                display: flex;
                flex-flow: row;
                justify-content: center;
                align-items: center;
                font-weight: normal;
                font-size: auto;
                color: #fff;
                cursor: pointer;
                transition: all .5s;
            }
            .title-letter{
                font-size: 30px;
                font-weight: bold;
                color: #fff;
            }
            .fade-enter-active, .fade-leave-active {
                transition: opacity .5s
            }
            .fade-enter, .fade-leave-to /* .fade-leave-active below version 2.1.8 */ {
                opacity: 0
            }
            .active{
                background-color: rgba(0,0,0,0.5);
                color: #000;
            }
        </style>

        <script src="https://cdn.tailwindcss.com"></script>

    </head>
    <body class="antialiased">

        <div class="flex items-center justify-center border">

            <a href="{{ route('simulator') }}" class="border p-6 m-3 bg-black text-white text-center rounded-lg">{{ __('Go To Simulator') }}</a>

            <div class="w-full grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-1 flex items-center justify-center border p-2 md:p-3 overflow-y-scroll">
                @foreach($cartons as $mode => $data)

                    <!-- Modo Horizontal -->
                    @if( $mode == 'H' )

                    @else
                        <!-- Modo Vertical (Default) -->
                        @foreach($data['cartons'] as $number => $carton)

                            <div id="carton_{{ $number }}" class="w-[200px] md:w-[200px] h-[220px] md:h-[320px] p-2 bg-[#A12929] m-1 rounded-lg md:rounded-sm self-center flex flex-row justify-between shadow-[2px_1px_1px_1px_#ccc] relative">
                            @php $cols = 0; @endphp
                            @foreach($carton as $letter => $series)

                                @if( $cols <= ($data['columns'] - 1)  )
                                    @if(!$cols)
                                        <div class="absolute top-1 left-1/2 transform -translate-x-1/2 p-1 bg-white text-black-700 text-[12px] md:text-[14px] text-center font-bold rounded-sm">{{ $number }}</div>
                                    @endif
                                
                                    <div class="rounded-lg flex flex-col justify-between mt-8">
                                        <div class="font-bold text-white text-center text-[12px] md:text-[14px]">{{ $letter }}</div>
                                        @foreach($series as $rows => $serie)
                                            @if( $rows <= ($data['rows'] - 1)  )
                                                <div class="bg-[#C18C1A] rounded-sm md:rounded-lg flex items-center justify-center font-bold md:font-normal text-white text-[10px] md:text-[14px] transition-all duration-500 m-1 p-1">{{ $serie }}</div>
                                            @endif
                                        @endforeach
                                    </div>                                
                                    @php $cols++ @endphp
                                @endif
                            @endforeach
                            </div>
                        @endforeach

                    @endif

                @endforeach

            </div>

        </div>
        
    </body>
</html>
