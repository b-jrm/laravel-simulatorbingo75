<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sala de juego | Bingo</title>

    {{-- Si tu proyecto ya compila Tailwind/Alpine con Vite, deja esta línea
         y borra los <script>/<link> de CDN de abajo. --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alternativa rápida vía CDN (comenta si usas @vite arriba) --}}
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}

    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-950 via-purple-900 to-fuchsia-900 text-white"
      x-data="bingoDashboard()" x-init="init()">

    <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:py-10">

        {{-- ============ HEADER ============ --}}
        <header class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="rounded-full bg-white/5 p-2 text-indigo-200/80 hover:bg-white/10 hover:text-white transition" title="Salir de la sala">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20z"/>
                    </svg>
                </a>
                <div>
                    <span class="text-xs font-medium uppercase tracking-wide text-fuchsia-200/80">Partida en curso</span>
                    <h1 class="text-2xl sm:text-3xl font-black tracking-tight">BINGO<span class="text-fuchsia-400">75</span></h1>
                </div>
            </div>

            <div class="flex items-center gap-3">
                {{-- Última bola --}}
                <div class="flex items-center gap-3 rounded-2xl border border-white/10 bg-white/5 px-4 py-2 backdrop-blur">
                    <span class="text-xs text-indigo-200/70">Última bola</span>
                    <div class="flex h-11 w-11 items-center justify-center rounded-full bg-fuchsia-500 font-black shadow-lg shadow-fuchsia-900/40"
                         x-text="currentCall ? letterFor(currentCall) + currentCall : '--'"></div>
                </div>

                {{-- Botón configuración --}}
                <button @click="settingsOpen = true"
                        class="rounded-full border border-white/10 bg-white/5 p-3 text-indigo-100 hover:bg-white/10 transition"
                        title="Configuración">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M19.14 12.94a7.14 7.14 0 0 0 .06-.94 7.14 7.14 0 0 0-.06-.94l2.03-1.58a.5.5 0 0 0 .12-.64l-1.92-3.32a.5.5 0 0 0-.6-.22l-2.39.96a7.3 7.3 0 0 0-1.63-.94l-.36-2.54a.5.5 0 0 0-.5-.42h-3.84a.5.5 0 0 0-.5.42l-.36 2.54c-.59.24-1.14.56-1.63.94l-2.39-.96a.5.5 0 0 0-.6.22L2.79 8.84a.5.5 0 0 0 .12.64L4.94 11a7.14 7.14 0 0 0 0 1.88l-2.03 1.58a.5.5 0 0 0-.12.64l1.92 3.32c.14.24.42.32.6.22l2.39-.96c.49.38 1.04.7 1.63.94l.36 2.54a.5.5 0 0 0 .5.42h3.84a.5.5 0 0 0 .5-.42l.36-2.54c.59-.24 1.14-.56 1.63-.94l2.39.96c.24.1.46 0 .6-.22l1.92-3.32a.5.5 0 0 0-.12-.64l-2.03-1.58zM12 15.5A3.5 3.5 0 1 1 12 8.5a3.5 3.5 0 0 1 0 7z"/>
                    </svg>
                </button>
            </div>
        </header>

        {{-- ============ SECUENCIA DE SERIES ============ --}}
        <section class="mt-6 rounded-3xl border border-white/10 bg-white/5 p-4 sm:p-5 backdrop-blur">
            <div class="mb-3 flex items-center justify-between">
                <h2 class="text-sm font-bold uppercase tracking-wide text-indigo-100">Secuencia de series</h2>
                <span class="text-xs text-indigo-200/60">Últimas <span x-text="Math.min(lastCalls.length, 6)"></span> bolas</span>
            </div>

            {{-- overflow-hidden: si no caben todas las bolas en pantalla, se recortan en vez de generar scroll --}}
            <div class="flex items-center gap-3 overflow-hidden">
                <template x-if="lastCalls.length === 0">
                    <span class="text-xs text-indigo-200/40">Aún no se ha cantado ninguna bola</span>
                </template>
                <template x-for="n in [...lastCalls].slice(0, 6).reverse()" :key="'serie-' + n">
                    <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full text-sm font-black transition sm:h-14 sm:w-14 sm:text-base"
                         :class="n === currentCall
                            ? 'scale-110 bg-fuchsia-500 text-white shadow-lg shadow-fuchsia-900/40 ring-4 ring-fuchsia-300/50'
                            : 'bg-white/10 text-indigo-100'"
                         x-text="letterFor(n) + n"></div>
                </template>
            </div>
        </section>

        {{-- Controles demo (reemplazar por integración real: Echo/Pusher/WebSocket) --}}
        <div class="mt-4 flex flex-wrap gap-3">
            <button @click="callNext()"
                    class="rounded-xl bg-fuchsia-500 px-4 py-2 text-sm font-bold hover:bg-fuchsia-400 transition">
                Llamar siguiente bola (demo)
            </button>
            <button @click="resetGame()"
                    class="rounded-xl border border-white/15 bg-white/5 px-4 py-2 text-sm font-bold text-indigo-100 hover:bg-white/10 transition">
                Reiniciar partida
            </button>
        </div>

        {{-- ============ GRID PRINCIPAL ============ --}}
        {{-- Cartones = panel central protagonista. Tablero = ayuda visual pequeña. Modos ganadores = referencia lateral. --}}
        <div class="mt-6 grid grid-cols-1 gap-6 lg:grid-cols-12 lg:items-start">

            {{-- ---- IZQUIERDA: Modos ganadores ---- --}}
            <aside class="order-3 lg:order-1 lg:col-span-3">
                <section class="rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur lg:sticky lg:top-6">
                    <h2 class="mb-4 text-sm font-bold uppercase tracking-wide text-indigo-100">Modos ganadores</h2>
                    <div class="flex flex-wrap gap-2 lg:flex-col lg:flex-nowrap lg:items-stretch">
                        <template x-for="mode in winningModes" :key="mode.key">
                            <span
                                class="flex items-center gap-1.5 rounded-full border px-3 py-1.5 text-xs font-bold transition lg:rounded-xl lg:justify-between"
                                :class="mode.achieved
                                    ? 'border-emerald-400/60 bg-emerald-500/20 text-emerald-200'
                                    : 'border-white/15 bg-white/5 text-indigo-100/80'">
                                <span x-text="mode.label"></span>
                                <svg x-show="mode.achieved" class="h-3.5 w-3.5 shrink-0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M9 16.17 4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                </svg>
                            </span>
                        </template>
                    </div>
                </section>
            </aside>

            {{-- ---- CENTRO: Mis cartones (panel principal del juego) ---- --}}
            <section class="order-1 lg:order-2 lg:col-span-6 rounded-3xl border border-fuchsia-400/30 bg-white/[0.07] p-5 shadow-2xl shadow-fuchsia-950/40 ring-1 ring-fuchsia-500/10 backdrop-blur sm:p-6">
                <h2 class="mb-5 flex items-center justify-between text-sm font-bold uppercase tracking-wide text-indigo-100">
                    Mis cartones
                    <span class="rounded-full bg-white/10 px-2 py-0.5 text-xs font-semibold" x-text="cards.length + ' activos'"></span>
                </h2>

                <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                    <template x-for="(card, cIndex) in cards" :key="cIndex">
                        <div class="rounded-2xl border border-white/10 bg-indigo-950/40 p-3 sm:p-4">
                            <p class="mb-2 text-center text-xs font-bold text-fuchsia-200">Cartón #<span x-text="cIndex + 1"></span></p>

                            <div class="grid grid-cols-5 gap-1 text-center">
                                <template x-for="letter in ['B','I','N','G','O']" :key="letter">
                                    <div class="text-xs font-black text-fuchsia-300 sm:text-sm" x-text="letter"></div>
                                </template>
                            </div>

                            <div class="mt-1 grid grid-cols-5 gap-1 sm:gap-1.5">
                                <template x-for="row in [0,1,2,3,4]" :key="row">
                                    <template x-for="letter in ['B','I','N','G','O']" :key="letter">
                                        <div
                                            class="flex aspect-square items-center justify-center rounded-md text-xs font-bold transition sm:text-sm"
                                            :class="isCellMarked(card, letter, row)
                                                ? 'bg-fuchsia-500 text-white shadow shadow-fuchsia-900/40'
                                                : 'bg-white/5 text-indigo-100/80'"
                                            x-text="cardCell(card, letter, row)"
                                        ></div>
                                    </template>
                                </template>
                            </div>
                        </div>
                    </template>
                </div>

                {{-- Botón BINGO --}}
                <button @click="claimBingo()"
                        class="sticky bottom-4 z-20 mt-6 flex w-full items-center justify-center gap-2 rounded-2xl bg-gradient-to-r from-fuchsia-500 to-pink-500 px-6 py-5 text-xl font-black uppercase tracking-wide text-white shadow-2xl shadow-fuchsia-900/50 transition hover:scale-[1.02] active:scale-100 animate-pulse-slow lg:static">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2 9.5 8.5 3 9l5 4.5L6.5 20 12 16.5 17.5 20 16 13.5l5-4.5-6.5-.5z"/>
                    </svg>
                    ¡BINGO!
                </button>
            </section>

            {{-- ---- DERECHA: Tablero compacto (solo ayuda visual) ---- --}}
            <aside class="order-2 lg:order-3 lg:col-span-3">
                <section class="rounded-3xl border border-white/10 bg-white/5 p-4 backdrop-blur lg:sticky lg:top-6">
                    <div class="mb-3 flex items-center justify-between">
                        <h2 class="text-xs font-bold uppercase tracking-wide text-indigo-100">Tablero</h2>
                        <span class="text-[10px] text-indigo-200/60"><span x-text="calledNumbers.length"></span>/75</span>
                    </div>

                    <div class="grid grid-cols-5 gap-1 text-center">
                        <template x-for="l in letters" :key="'head-' + l.key">
                            <div class="text-[10px] font-black text-fuchsia-300 sm:text-xs" x-text="l.key"></div>
                        </template>
                    </div>

                    <div class="mt-1 grid grid-cols-5 gap-1">
                        <template x-for="l in letters" :key="'col-' + l.key">
                            <div class="flex flex-col gap-1">
                                <template x-for="n in boardColumn(l.key)" :key="n">
                                    <div
                                        class="flex aspect-square items-center justify-center rounded text-[8px] font-bold transition sm:text-[9px]"
                                        :class="isCalled(n)
                                            ? (n === currentCall ? 'bg-fuchsia-500 text-white ring-1 ring-fuchsia-300 animate-pulse' : 'bg-fuchsia-500/70 text-white')
                                            : 'bg-white/5 text-indigo-100/30'"
                                        x-text="n"
                                    ></div>
                                </template>
                            </div>
                        </template>
                    </div>
                </section>
            </aside>
        </div>
    </div>

    {{-- ============ DRAWER DE CONFIGURACIÓN ============ --}}
    <div x-show="settingsOpen" x-cloak class="fixed inset-0 z-40">
        <div class="absolute inset-0 bg-black/60" @click="settingsOpen = false"
             x-show="settingsOpen" x-transition:enter="transition-opacity duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"></div>

        <div class="absolute right-0 top-0 h-full w-full max-w-sm overflow-y-auto border-l border-white/10 bg-indigo-950/95 p-6 backdrop-blur-xl"
             x-show="settingsOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full">

            <div class="mb-6 flex items-center justify-between">
                <h2 class="text-xl font-black">Configuración</h2>
                <button @click="settingsOpen = false" class="rounded-full p-2 hover:bg-white/10 transition">
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

    {{-- ============ MODAL CONFIRMACIÓN BINGO ============ --}}
    <div x-show="showBingoModal" x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div class="absolute inset-0 bg-black/70" @click="showBingoModal = false"></div>
        <div class="relative w-full max-w-sm rounded-3xl border border-white/10 bg-indigo-950 p-8 text-center shadow-2xl"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-90"
             x-transition:enter-end="opacity-100 scale-100">
            <h3 class="text-2xl font-black text-fuchsia-300">¡BINGO cantado!</h3>
            <p class="mt-2 text-sm text-indigo-100/80">Estamos verificando tu cartón contra las bolas cantadas...</p>
            <button @click="showBingoModal = false"
                    class="mt-6 w-full rounded-xl bg-fuchsia-500 px-6 py-3 text-sm font-bold hover:bg-fuchsia-400 transition">
                Entendido
            </button>
        </div>
    </div>

    <style>
        @keyframes pulse-slow {
            0%, 100% { box-shadow: 0 0 0 0 rgba(217, 70, 239, .5); }
            50% { box-shadow: 0 0 0 12px rgba(217, 70, 239, 0); }
        }
        .animate-pulse-slow { animation: pulse-slow 2s infinite; }
    </style>

    <script>
        function bingoDashboard() {
            return {
                // ---- Configuración ----
                settingsOpen: false,
                soundOn: true,
                volume: 70,
                autoSelect: false,
                autoSeries: false,
                callSpeed: 'normal',
                vibration: true,

                // ---- Estado del juego ----
                calledNumbers: [],
                currentCall: null,
                lastCalls: [],
                showBingoModal: false,

                letters: [
                    { key: 'B', from: 1, to: 15 },
                    { key: 'I', from: 16, to: 30 },
                    { key: 'N', from: 31, to: 45 },
                    { key: 'G', from: 46, to: 60 },
                    { key: 'O', from: 61, to: 75 },
                ],

                winningModes: [
                    { key: 'linea_horizontal', label: 'Línea horizontal', achieved: false },
                    { key: 'diagonal', label: 'Diagonal', achieved: true },
                    { key: 'cuatro_esquinas', label: 'Cuatro esquinas', achieved: false },
                    { key: 'carton_lleno', label: 'Cartón lleno', achieved: false },
                ],

                cards: [],

                // ---- Ciclo de vida ----
                init() {
                    // TODO: reemplazar por los cartones reales del usuario (vía props/blade @ json o fetch a la API)
                    this.cards = this.generateCards(2);
                    // Demo: precarga algunas bolas para ilustrar el tablero marcado
                    [12, 27, 34, 41, 58, 63].forEach(n => this.markCalled(n));
                },

                // ---- Utilidades del tablero ----
                letterFor(n) {
                    return this.letters.find(l => n >= l.from && n <= l.to)?.key ?? '';
                },

                boardColumn(letter) {
                    const l = this.letters.find(x => x.key === letter);
                    const arr = [];
                    for (let n = l.from; n <= l.to; n++) arr.push(n);
                    return arr;
                },

                isCalled(n) {
                    return this.calledNumbers.includes(n);
                },

                markCalled(n) {
                    if (this.isCalled(n)) return;
                    this.calledNumbers.push(n);
                    this.currentCall = n;
                    this.lastCalls.unshift(n);
                    if (this.lastCalls.length > 8) this.lastCalls.pop();
                },

                // Simulación de llamado (sustituir por evento real del backend: Echo/Pusher/WebSocket)
                callNext() {
                    const pool = [];
                    for (let n = 1; n <= 75; n++) if (!this.isCalled(n)) pool.push(n);
                    if (pool.length === 0) return;
                    const n = pool[Math.floor(Math.random() * pool.length)];
                    this.markCalled(n);
                },

                resetGame() {
                    this.calledNumbers = [];
                    this.currentCall = null;
                    this.lastCalls = [];
                    this.cards = this.generateCards(this.cards.length || 2);
                    this.winningModes.forEach(m => m.achieved = false);
                },

                // ---- Cartones ----
                generateCards(count) {
                    const cards = [];
                    for (let c = 0; c < count; c++) {
                        const card = {};
                        this.letters.forEach(l => {
                            const pool = [];
                            for (let n = l.from; n <= l.to; n++) pool.push(n);
                            const nums = [];
                            while (nums.length < 5) {
                                const idx = Math.floor(Math.random() * pool.length);
                                nums.push(pool.splice(idx, 1)[0]);
                            }
                            card[l.key] = nums;
                        });
                        cards.push(card);
                    }
                    return cards;
                },

                cardCell(card, letter, row) {
                    if (letter === 'N' && row === 2) return 'FREE';
                    return card[letter][row];
                },

                isCellMarked(card, letter, row) {
                    if (letter === 'N' && row === 2) return true;
                    return this.isCalled(card[letter][row]);
                },

                // ---- Acciones ----
                claimBingo() {
                    this.showBingoModal = true;
                    // TODO: enviar verificación al backend (POST a ruta de validación de cartón ganador)
                }
            }
        }
    </script>
</body>
</html>