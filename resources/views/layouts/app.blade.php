<x-layouts::app.sidebar class="rounded-l-2xl" :title="$title ?? null">
    <flux:main class="rounded-l-2xl bg-white dark:bg-zinc-950 !p-5">
        {{ $slot }}
    </flux:main>
</x-layouts::app.sidebar>
