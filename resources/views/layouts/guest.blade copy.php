<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bingo 75 | Juega ahora</title>

    {{-- Si tu proyecto ya compila Tailwind/Alpine con Vite (setup típico de Laravel 10),
         deja estas dos líneas y borra los <script>/<link> de CDN de abajo. --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alternativa rápida vía CDN (comenta si usas @vite arriba) --}}
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
</head>
<body class="min-h-screen bg-gradient-to-br from-indigo-950 via-purple-900 to-fuchsia-900 text-white overflow-x-hidden"
      x-data="{
          balls: Array.from({ length: 16 }, (_, i) => ({
              id: i,
              num: Math.floor(Math.random() * 75) + 1,
              left: Math.random() * 100,
              delay: (Math.random() * 10).toFixed(2),
              duration: (12 + Math.random() * 10).toFixed(2),
              size: 40 + Math.floor(Math.random() * 30)
          }))
      }"
>

    {{-- Bolas de bingo flotando de fondo (decorativo) --}}
    <div class="pointer-events-none fixed inset-0 overflow-hidden opacity-30">
        <template x-for="ball in balls" :key="ball.id">
            <div
                class="absolute rounded-full bg-white/90 text-indigo-900 font-extrabold flex items-center justify-center shadow-lg animate-float"
                :style="`left: ${ball.left}%; width: ${ball.size}px; height: ${ball.size}px; font-size: ${ball.size/2.5}px; animation-delay: ${ball.delay}s; animation-duration: ${ball.duration}s;`"
                x-text="ball.num"
            ></div>
        </template>
    </div>

    {{-- Contenido principal --}}
    <main class="relative z-10 flex min-h-screen flex-col items-center justify-center px-6 py-16 text-center">

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

        {{-- Botones principales --}}
        <div class="mt-10 flex w-full max-w-md flex-col gap-4 sm:flex-row sm:justify-center">

            {{-- Botón Jugar -> Formulario del simulador --}}
            <a href="{{ route('bingo.simulator.form') }}"
               class="group relative inline-flex items-center justify-center gap-2 rounded-2xl bg-fuchsia-500 px-8 py-4 text-lg font-bold text-white shadow-xl shadow-fuchsia-900/40 transition
                      hover:bg-fuchsia-400 hover:-translate-y-0.5 active:translate-y-0 focus:outline-none focus:ring-4 focus:ring-fuchsia-300/50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M8 5v14l11-7L8 5z"/>
                </svg>
                Jugar ahora
            </a>

            {{-- Botón Mi Cuenta -> Sign in / Sign up --}}
            <a href="{{ route('myaccount') }}"
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
    </main>

    <footer class="relative z-10 pb-6 text-center text-xs text-indigo-200/50">
        &copy; {{ date('Y') }} Bingo75. Todos los derechos reservados.
    </footer>

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
</body>
</html>