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

    <div class="pointer-events-none fixed inset-0 overflow-hidden opacity-30">
        <template x-for="ball in balls" :key="ball.id">
            <div
                class="absolute rounded-full bg-white/90 text-indigo-900 font-extrabold flex items-center justify-center shadow-lg animate-float"
                :style="`left: ${ball.left}%; width: ${ball.size}px; height: ${ball.size}px; font-size: ${ball.size/2.5}px; animation-delay: ${ball.delay}s; animation-duration: ${ball.duration}s;`"
                x-text="ball.num"
            ></div>
        </template>
    </div>
    
    <span class="mb-4 inline-block rounded-full bg-white/10 px-4 py-1 text-sm font-medium tracking-wide text-fuchsia-200 backdrop-blur">
        75 Bolas · Simulador en vivo
    </span>

    <h1 class="text-5xl sm:text-6xl md:text-7xl font-black tracking-tight drop-shadow-lg">
        BINGO<span class="text-fuchsia-400">75</span>
    </h1>

    <p class="mt-4 max-w-xl text-lg sm:text-xl text-indigo-100/90">
        Marca tus cartones, sigue el sorteo en tiempo real y grita ¡BINGO!
        desde donde estés.
    </p>

    <div class="mt-10 flex w-full max-w-md flex-col gap-4 sm:flex-row sm:justify-center">

        <a href="{{ route('simulator') }}"
            class="group relative inline-flex items-center justify-center gap-2 rounded-2xl bg-fuchsia-500 px-8 py-4 text-lg font-bold text-white shadow-xl shadow-fuchsia-900/40 transition
                    hover:bg-fuchsia-400 hover:-translate-y-0.5 active:translate-y-0 focus:outline-none focus:ring-4 focus:ring-fuchsia-300/50">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                <path d="M8 5v14l11-7L8 5z"/>
            </svg>
            Jugar ahora
        </a>

        <a href="#"
            class="inline-flex items-center justify-center gap-2 rounded-2xl border-2 border-white/40 bg-white/5 px-8 py-4 text-lg font-bold text-white backdrop-blur transition
                    hover:bg-white/15 hover:-translate-y-0.5 active:translate-y-0 focus:outline-none focus:ring-4 focus:ring-white/30">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 12c2.7 0 8 1.34 8 4v2H4v-2c0-2.66 5.3-4 8-4zm0-2a4 4 0 1 0 0-8 4 4 0 0 0 0 8z"/>
            </svg>
            Mi Cuenta
        </a>
    </div>

    <p class="mt-6 text-sm text-indigo-200/70">
        ¿Ya tienes cuenta? El botón de "Mi Cuenta" te lleva a iniciar sesión o registrarte.
    </p>

    <!-- <x-slot name="footer"></x-slot> -->

    <x-slot name="scripts">
        
    </x-slot>

</x-guest-layout>
<!-- <img src="{{ asset('storage/assets/img/logo.png') }}" class="w-auto h-[40px]"></img> -->