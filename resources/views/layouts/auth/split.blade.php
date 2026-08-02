<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>

<body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
    <div
        class="relative grid h-dvh flex-col items-center justify-center px-8 sm:px-0 lg:max-w-none lg:grid-cols-2 lg:px-0">
        <div
            class="bg-muted relative hidden h-full flex-col p-10 text-white lg:flex dark:border-e dark:border-neutral-800">
            <canvas id="auth-pixel-gradient" class="absolute inset-0 h-full w-full bg-neutral-950"></canvas>

            <a href="{{ route('home') }}" class="relative z-20 flex items-center text-lg font-medium" wire:navigate>
                <span class="flex h-10 w-10 items-center justify-center rounded-md">
                    <x-app-logo-icon class="me-2 h-7 fill-current text-white" />
                </span>
                {{ config('app.name', 'Laravel') }}
            </a>

            <div class="relative z-20 mt-auto">
                <blockquote class="space-y-2">
                    <flux:heading size="lg">&ldquo;طراحی و توسعه&rdquo;</flux:heading>
                    <footer>
                        <flux:heading>امین تورچی</flux:heading>
                    </footer>
                </blockquote>
            </div>
        </div>
        <div class="w-full lg:p-8">
            <div class="mx-auto flex w-full flex-col justify-center space-y-6 sm:w-[350px]">
                <a href="{{ route('home') }}" class="z-20 flex flex-col items-center gap-2 font-medium lg:hidden"
                    wire:navigate>
                    <span class="flex h-9 w-9 items-center justify-center rounded-md">
                        <x-app-logo-icon class="size-9 fill-current text-black dark:text-white" />
                    </span>

                    <span class="sr-only">{{ config('app.name', 'Laravel') }}</span>
                </a>
                {{ $slot }}
            </div>
        </div>
    </div>

    @persist('toast')
    <flux:toast.group>
        <flux:toast />
    </flux:toast.group>
    @endpersist

    <script>
        (function () {
            const canvas = document.getElementById('auth-pixel-gradient');
            if (!canvas) return;

            const ctx = canvas.getContext('2d');
            ctx.imageSmoothingEnabled = false;

            // Fine "pixel art" cell size in CSS px — small on purpose.
            const PIXEL_SIZE = 4;

            const lowRes = document.createElement('canvas');
            const lowCtx = lowRes.getContext('2d');

            const stops = [
                [43, 44, 43],
                [43, 44, 43],
                [76, 76, 72],
                [164, 157, 142],
                // [232, 228, 216],
            ];

            const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

            let cols = 0, rows = 0, imageData, data;

            function resize() {
                const parent = canvas.parentElement;
                const width = parent.clientWidth;
                const height = parent.clientHeight;

                canvas.width = width;
                canvas.height = height;

                cols = Math.max(1, Math.round(width / PIXEL_SIZE));
                rows = Math.max(1, Math.round(height / PIXEL_SIZE));

                lowRes.width = cols;
                lowRes.height = rows;
                imageData = lowCtx.createImageData(cols, rows);
                data = imageData.data;
            }

            function lerp(a, b, t) {
                return a + (b - a) * t;
            }

            function paletteColor(t) {
                const n = stops.length;
                const scaled = ((t % 1) + 1) % 1 * n;
                const i = Math.floor(scaled) % n;
                const j = (i + 1) % n;
                const localT = scaled - Math.floor(scaled);
                const c1 = stops[i], c2 = stops[j];
                return [
                    lerp(c1[0], c2[0], localT) | 0,
                    lerp(c1[1], c2[1], localT) | 0,
                    lerp(c1[2], c2[2], localT) | 0,
                ];
            }

            let time = 0;

            function draw() {
                const cx = cols / 2;
                const cy = rows / 2;
                let idx = 0;

                for (let y = 0; y < rows; y++) {
                    for (let x = 0; x < cols; x++) {
                        // Several independent frequencies/phases (plasma-style) —
                        // deliberately not a single uniform sweeping wave.
                        const dx = x - cx;
                        const dy = y - cy;
                        const v =
                            Math.sin(x * 0.05 + time * 1.0) +
                            Math.sin(y * 0.045 - time * 0.7) +
                            Math.sin((x + y) * 0.035 + time * 1.4) +
                            Math.sin(Math.sqrt(dx * dx + dy * dy) * 0.06 - time * 0.5);

                        const t = (v / 4 + 1) / 2;
                        const [r, g, b] = paletteColor(t);

                        data[idx++] = r;
                        data[idx++] = g;
                        data[idx++] = b;
                        data[idx++] = 255;
                    }
                }

                lowCtx.putImageData(imageData, 0, 0);
                ctx.clearRect(0, 0, canvas.width, canvas.height);
                ctx.drawImage(lowRes, 0, 0, canvas.width, canvas.height);
            }

            function loop() {
                time += 0.006;
                draw();
                requestAnimationFrame(loop);
            }

            resize();
            window.addEventListener('resize', resize);

            if (reduceMotion) {
                draw();
            } else {
                loop();
            }
        })();
    </script>

    @fluxScripts
</body>

</html>