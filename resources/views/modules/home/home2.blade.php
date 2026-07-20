<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurar partida | Bingo</title>

    {{-- Si tu proyecto ya compila Tailwind/Alpine con Vite, deja esta línea
         y borra los <script>/<link> de CDN de abajo. --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alternativa rápida vía CDN (comenta si usas @vite arriba) --}}
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-950 via-purple-900 to-fuchsia-900 text-white overflow-x-hidden"
      x-data="bingoForm()"
>

    {{-- Bolas de bingo flotando de fondo (decorativo) --}}
    <div class="pointer-events-none fixed inset-0 overflow-hidden opacity-20">
        <template x-for="ball in balls" :key="ball.id">
            <div
                class="absolute rounded-full bg-white/90 text-indigo-900 font-extrabold flex items-center justify-center shadow-lg animate-float"
                :style="`left: ${ball.left}%; width: ${ball.size}px; height: ${ball.size}px; font-size: ${ball.size/2.5}px; animation-delay: ${ball.delay}s; animation-duration: ${ball.duration}s;`"
                x-text="ball.num"
            ></div>
        </template>
    </div>

    <main class="relative z-10 flex min-h-screen flex-col items-center justify-center px-4 py-12">

        <a href="{{ route('home') }}"
           class="absolute left-4 top-4 sm:left-8 sm:top-8 inline-flex items-center gap-1 text-sm text-indigo-200/80 hover:text-white transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor">
                <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20z"/>
            </svg>
            Volver
        </a>

        <div class="w-full max-w-lg text-center mb-8">
            <span class="mb-3 inline-block rounded-full bg-white/10 px-4 py-1 text-sm font-medium tracking-wide text-fuchsia-200 backdrop-blur">
                Configura tu partida
            </span>
            <h1 class="text-4xl sm:text-5xl font-black tracking-tight drop-shadow-lg">
                Simulador de <span class="text-fuchsia-400">Bingo</span>
            </h1>
        </div>

        <form method="POST" action="{{ route('simulator') }}"
              class="w-full max-w-lg rounded-3xl border border-white/10 bg-white/5 p-6 sm:p-8 shadow-2xl backdrop-blur-md space-y-8">
            @csrf

            {{-- Tipo de bingo --}}
            <div>
                <label class="mb-3 block text-sm font-semibold text-indigo-100">Tipo de bingo</label>
                <div class="grid grid-cols-2 gap-3">
                    <template x-for="option in bingoTypes" :key="option.value">
                        <button type="button"
                                @click="setBingoType(option.value)"
                                :class="bingoType === option.value
                                    ? 'bg-fuchsia-500 border-fuchsia-400 shadow-lg shadow-fuchsia-900/40'
                                    : 'bg-white/5 border-white/15 hover:bg-white/10'"
                                class="rounded-xl border-2 px-4 py-3 text-sm font-bold transition">
                            <span x-text="option.label"></span>
                        </button>
                    </template>
                </div>
                <input type="hidden" name="bingo_type" :value="bingoType">
            </div>

            {{-- Modos ganadores --}}
            <div>
                <label class="mb-3 block text-sm font-semibold text-indigo-100">Modos ganadores</label>
                <div class="grid grid-cols-2 gap-2">
                    <template x-for="mode in currentWinningModes" :key="mode.value">
                        <label
                            :class="winningModes.includes(mode.value)
                                ? 'bg-fuchsia-500/90 border-fuchsia-400'
                                : 'bg-white/5 border-white/15 hover:bg-white/10'"
                            class="flex cursor-pointer items-center gap-2 rounded-xl border-2 px-3 py-2.5 text-sm font-medium transition select-none">
                            <input type="checkbox"
                                   name="winning_modes[]"
                                   :value="mode.value"
                                   x-model="winningModes"
                                   class="sr-only">
                            <svg x-show="winningModes.includes(mode.value)" class="h-4 w-4 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M9 16.17 4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                            </svg>
                            <span x-text="mode.label"></span>
                        </label>
                    </template>
                </div>
                <p class="mt-2 text-xs text-indigo-200/60">Puedes elegir uno o varios modos de victoria.</p>
            </div>

            {{-- Cantidad de cartones --}}
            <div>
                <label class="mb-3 block text-sm font-semibold text-indigo-100">Cantidad de cartones</label>
                <div class="grid grid-cols-4 gap-3">
                    <template x-for="n in [1,2,3,4]" :key="n">
                        <button type="button"
                                @click="cardCount = n"
                                :class="cardCount === n
                                    ? 'bg-fuchsia-500 border-fuchsia-400 shadow-lg shadow-fuchsia-900/40'
                                    : 'bg-white/5 border-white/15 hover:bg-white/10'"
                                class="rounded-xl border-2 py-3 text-lg font-bold transition">
                            <span x-text="n"></span>
                        </button>
                    </template>
                </div>
                <input type="hidden" name="card_count" :value="cardCount">
            </div>

            {{-- Selección automática --}}
            <div>
                <label class="mb-3 block text-sm font-semibold text-indigo-100">Selección automática</label>
                <div class="grid grid-cols-2 gap-3">
                    <template x-for="option in yesNo" :key="'auto-select-' + option.value">
                        <button type="button"
                                @click="autoSelect = option.value"
                                :class="autoSelect === option.value
                                    ? 'bg-fuchsia-500 border-fuchsia-400 shadow-lg shadow-fuchsia-900/40'
                                    : 'bg-white/5 border-white/15 hover:bg-white/10'"
                                class="rounded-xl border-2 px-4 py-3 text-sm font-bold transition">
                            <span x-text="option.label"></span>
                        </button>
                    </template>
                </div>
                <input type="hidden" name="auto_select" :value="autoSelect">
            </div>

            {{-- Series automáticas --}}
            <div>
                <label class="mb-3 block text-sm font-semibold text-indigo-100">Series automáticas</label>
                <div class="grid grid-cols-2 gap-3">
                    <template x-for="option in yesNo" :key="'auto-series-' + option.value">
                        <button type="button"
                                @click="autoSeries = option.value"
                                :class="autoSeries === option.value
                                    ? 'bg-fuchsia-500 border-fuchsia-400 shadow-lg shadow-fuchsia-900/40'
                                    : 'bg-white/5 border-white/15 hover:bg-white/10'"
                                class="rounded-xl border-2 px-4 py-3 text-sm font-bold transition">
                            <span x-text="option.label"></span>
                        </button>
                    </template>
                </div>
                <input type="hidden" name="auto_series" :value="autoSeries">
            </div>

            {{-- Botón Iniciar Juego --}}
            <button type="submit"
                    :disabled="winningModes.length === 0"
                    :class="winningModes.length === 0 ? 'opacity-50 cursor-not-allowed' : 'hover:bg-fuchsia-400 hover:-translate-y-0.5'"
                    class="group flex w-full items-center justify-center gap-2 rounded-2xl bg-fuchsia-500 px-8 py-4 text-lg font-bold text-white shadow-xl shadow-fuchsia-900/40 transition active:translate-y-0 focus:outline-none focus:ring-4 focus:ring-fuchsia-300/50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M8 5v14l11-7L8 5z"/>
                </svg>
                Iniciar Juego
            </button>
            <p x-show="winningModes.length === 0" class="text-center text-xs text-fuchsia-200/80 -mt-4">
                Selecciona al menos un modo ganador para continuar.
            </p>
        </form>
    </main>

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

    <script>
        function bingoForm() {
            return {
                bingoType: '75',
                cardCount: 1,
                autoSelect: 'si',
                autoSeries: 'si',
                winningModes: [],

                bingoTypes: [
                    { value: '75', label: 'Bingo 75 bolas' },
                    { value: '90', label: 'Bingo 90 bolas' },
                ],

                yesNo: [
                    { value: 'si', label: 'Sí' },
                    { value: 'no', label: 'No' },
                ],

                winningModesByType: {
                    75: [
                        { value: 'linea_horizontal', label: 'Línea horizontal' },
                        { value: 'linea_vertical',   label: 'Línea vertical' },
                        { value: 'diagonal',         label: 'Diagonal' },
                        { value: 'cuatro_esquinas',  label: 'Cuatro esquinas' },
                        { value: 'cruz',             label: 'Cruz' },
                        { value: 'carton_lleno',     label: 'Cartón lleno' },
                    ],
                    90: [
                        { value: 'una_linea',    label: '1 línea' },
                        { value: 'dos_lineas',   label: '2 líneas' },
                        { value: 'carton_lleno', label: 'Cartón lleno (Full house)' },
                    ],
                },

                balls: Array.from({ length: 14 }, (_, i) => ({
                    id: i,
                    num: Math.floor(Math.random() * 75) + 1,
                    left: Math.random() * 100,
                    delay: (Math.random() * 10).toFixed(2),
                    duration: (12 + Math.random() * 10).toFixed(2),
                    size: 40 + Math.floor(Math.random() * 30)
                })),

                get currentWinningModes() {
                    return this.winningModesByType[this.bingoType];
                },

                setBingoType(value) {
                    this.bingoType = value;
                    this.winningModes = [];
                }
            }
        }
    </script>
</body>
</html>