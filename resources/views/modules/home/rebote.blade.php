<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bolas rebotando | Demo</title>

    {{-- Si tu proyecto ya compila Tailwind/Alpine con Vite, deja esta línea
         y borra los <script>/<link> de CDN de abajo. --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Alternativa rápida vía CDN (comenta si usas @vite arriba) --}}
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
</head>
<body class="flex min-h-screen items-center justify-center bg-gradient-to-br from-indigo-950 via-purple-900 to-fuchsia-900 p-6 text-white">

    <div class="w-full max-w-xl" x-data="bouncingBalls()"
            x-init="init()">
        <h1 class="mb-1 text-center text-2xl font-black">Bolas de bingo rebotando</h1>
        <p class="mb-4 text-center text-sm text-indigo-200/70">
            Haz clic sobre una bola (o el botón) para lanzarla fuera del contenedor.
        </p>

        {{-- ============ CONTENEDOR CON EFECTO DE REBOTE ============ --}}
        <div
            class="relative h-72 w-full overflow-hidden rounded-3xl border border-white/10 bg-white/5 shadow-inner backdrop-blur sm:h-96"
        >
            <template x-for="ball in balls" :key="ball.id">
                <div
                    class="absolute left-0 top-0 flex items-center justify-center rounded-full bg-white font-black text-indigo-900 shadow-lg cursor-pointer select-none"
                    :style="ballStyle(ball)"
                    @click="launchBall(ball.id)"
                    x-text="ball.num"
                ></div>
            </template>
        </div>

        {{-- Controles de la demo --}}
        <div class="mt-4 flex justify-center gap-3">
            <button @click="launchRandom()"
                    class="rounded-xl bg-fuchsia-500 px-4 py-2 text-sm font-bold hover:bg-fuchsia-400 transition">
                Lanzar bola fuera 🎉
            </button>
            <button @click="addBall()"
                    class="rounded-xl border border-white/15 bg-white/5 px-4 py-2 text-sm font-bold text-indigo-100 hover:bg-white/10 transition">
                Agregar bola
            </button>
        </div>
    </div>

    <script>
        function bouncingBalls() {
            return {
                balls: [],
                nextId: 0,
                rafId: null,

                // ---- Ciclo de vida ----
                init() {
                    for (let i = 0; i < 8; i++) this.addBall();
                    this.loop();

                    // Detiene el loop de animación si el elemento se destruye (útil en SPA/Livewire)
                    this.$el.addEventListener('alpine:destroy', () => cancelAnimationFrame(this.rafId));
                },

                // ---- Crear una bola nueva dentro del contenedor ----
                addBall() {
                    const size = 34 + Math.random() * 14; // 34px - 48px
                    const w = this.$el.clientWidth;
                    const h = this.$el.clientHeight;

                    this.balls.push({
                        id: this.nextId++,
                        num: Math.floor(Math.random() * 75) + 1,
                        size,
                        x: Math.random() * Math.max(w - size, 0),
                        y: Math.random() * Math.max(h - size, 0),
                        vx: (Math.random() - 0.5) * 4 || 2,   // evita velocidad 0
                        vy: (Math.random() - 0.5) * 4 || 2,
                        launched: false,
                        out: false,
                    });
                },

                // ---- Estilo inline: posición vía transform (mejor rendimiento que left/top) ----
                ballStyle(ball) {
                    return `
                        width:${ball.size}px;
                        height:${ball.size}px;
                        font-size:${ball.size / 2.6}px;
                        transform:translate(${ball.x}px, ${ball.y}px);
                        transition:${ball.launched ? 'transform .8s cubic-bezier(.2,.8,.2,1), opacity .5s ease-in .3s' : 'none'};
                        opacity:${ball.out ? 0 : 1};
                    `;
                },

                // ---- Loop de física: rebota contra los 4 bordes del contenedor ----
                loop() {
                    const w = this.$el.clientWidth;
                    const h = this.$el.clientHeight;

                    this.balls.forEach(ball => {
                        if (ball.launched) return; // las lanzadas ya no siguen la física, se animan con CSS

                        ball.x += ball.vx;
                        ball.y += ball.vy;

                        if (ball.x <= 0) { ball.x = 0; ball.vx *= -1; }
                        if (ball.x + ball.size >= w) { ball.x = w - ball.size; ball.vx *= -1; }
                        if (ball.y <= 0) { ball.y = 0; ball.vy *= -1; }
                        if (ball.y + ball.size >= h) { ball.y = h - ball.size; ball.vy *= -1; }
                    });

                    this.rafId = requestAnimationFrame(() => this.loop());
                },

                // ---- Evento: lanza una bola específica fuera del div ----
                launchBall(id) {
                    const ball = this.balls.find(b => b.id === id);
                    if (!ball || ball.launched) return;

                    ball.launched = true;

                    // Dirección de salida aleatoria (mayormente hacia arriba)
                    const angleDeg = (Math.random() * 60 - 30) - 90;
                    const angleRad = angleDeg * Math.PI / 180;
                    const distance = 420;

                    ball.x += Math.cos(angleRad) * distance;
                    ball.y += Math.sin(angleRad) * distance;

                    // Al terminar la animación de salida, la quitamos y devolvemos una nueva
                    // para que el contenedor nunca se quede vacío.
                    setTimeout(() => {
                        ball.out = true;
                        setTimeout(() => {
                            this.balls = this.balls.filter(b => b.id !== id);
                            this.addBall();
                        }, 350);
                    }, 800);
                },

                // ---- Evento: lanza una bola aleatoria (botón) ----
                launchRandom() {
                    const active = this.balls.filter(b => !b.launched);
                    if (active.length === 0) return;
                    const ball = active[Math.floor(Math.random() * active.length)];
                    this.launchBall(ball.id);
                },
            };
        }
    </script>
</body>
</html>