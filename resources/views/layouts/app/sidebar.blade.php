<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl" class="dark">

<head>
    @include('partials.head')
</head>

<body class="h-screen overflow-hidden rounded-l-2xl bg-zinc-100 dark:bg-zinc-900 text-md">

    <div class="flex h-screen overflow-hidden">

        <flux:sidebar sticky collapsible class="h-full bg-zinc-100 dark:bg-zinc-900">
            <flux:sidebar.header>
                <flux:sidebar.brand href="{{ route('home') }}" wire:navigate
                    logo="{{ Auth::user()->avatar ?: asset('/images/avatar-placeholder.png') }}"
                    logo:dark="{{ Auth::user()->avatar ?: asset('/images/avatar-placeholder.png') }}"
                    name="مدیریت ساختمان {{ config('app.building_name') }}" />
                <flux:sidebar.collapse
                    class="in-data-flux-sidebar-on-desktop:not-in-data-flux-sidebar-collapsed-desktop:-mr-2" />
            </flux:sidebar.header>

            <flux:sidebar.nav>
                <flux:sidebar.item icon="home" href="{{ route('dashboard') }}" wire:navigate wire:current>داشبورد
                </flux:sidebar.item>
                <flux:sidebar.group expandable icon="building-office-2" heading="مدیریت ساختمان" class="grid">
                    <flux:sidebar.item icon="home" href="{{ route('units') }}" wire:current wire:navigate>
                        <div class="flex items-center justify-between gap-2 w-full">
                            <span>
                                واحد ها
                            </span>

                            <flux:badge size="sm" color="zinc">
                                {{ \App\Models\Unit::count() }}
                            </flux:badge>
                        </div>
                    </flux:sidebar.item>


                    <flux:sidebar.item icon="users" href="{{ route('users') }}" wire:current wire:navigate>
                        <div class="flex items-center justify-between gap-2 w-full">
                            <span>
                                افراد
                            </span>

                            <flux:badge size="sm" color="zinc">
                                {{ \App\Models\User::count() }}
                            </flux:badge>
                        </div>
                    </flux:sidebar.item>

                </flux:sidebar.group>
            </flux:sidebar.nav>

            <flux:sidebar.spacer />

            <flux:sidebar.nav class="gap-2">
                <flux:sidebar.item icon="cog-6-tooth" wire:navigate.hover href="{{ route('profile.edit') }}">تنظیمات
                    حساب
                </flux:sidebar.item>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <flux:sidebar.item as="button" type="submit" icon="arrow-left-start-on-rectangle" variant="danger"
                        class="w-full !text-red-500">
                        خروج از حساب
                    </flux:sidebar.item>
                </form>
            </flux:sidebar.nav>
        </flux:sidebar>

        <div class="flex h-full flex-1 flex-col overflow-hidden">

            <flux:header class="shrink-0">
                <flux:sidebar.collapse class="lg:hidden" />
                <flux:spacer />
                <flux:dropdown position="bottom" align="start">
                    <span class="text-xs">
                        {{ Auth::user()->name }} عزیز خوش امدید
                    </span>

                    <flux:navmenu>
                        <flux:navmenu.item href="{{ route('profile.edit') }}" wire:navigate.hover icon="cog">Settings
                        </flux:navmenu.item>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <flux:navmenu.item as="button" type="submit" icon="arrow-left-start-on-rectangle"
                                variant="danger" class="w-full">
                                Sign out
                            </flux:navmenu.item>
                        </form>
                    </flux:navmenu>
                </flux:dropdown>
            </flux:header>

            <main class="flex-1 overflow-y-auto rounded-tr-2xl">
                {{ $slot }}
            </main>

        </div>

    </div>

    @persist('toast')
    <flux:toast.group>
        <flux:toast />
    </flux:toast.group>
    @endpersist

    @fluxScripts
</body>

</html>