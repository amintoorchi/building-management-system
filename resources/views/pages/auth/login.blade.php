<x-layouts::auth :title="__('ورود')">
    <div class="flex flex-col gap-6" dir="rtl">
        <x-auth-header :title="__('ورود به حساب کاربری')" :description="__('شماره موبایل و رمز عبور خود را برای ورود وارد کنید')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <x-passkey-verify />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Phone Number -->
            <flux:input
                name="phone_number"
                :label="__('شماره موبایل')"
                :value="old('phone_number')"
                type="tel"
                required
                autofocus
                autocomplete="tel"
                placeholder="0914******"
            />

            <!-- Password -->
            <div class="relative">
                <flux:input
                    name="password"
                    :label="__('رمز عبور')"
                    type="password"
                    required
                    autocomplete="current-password"
                    :placeholder="__('رمز عبور')"
                    viewable
                />

                @if (Route::has('password.request'))
                    <flux:link class="absolute top-0 text-sm end-0" :href="route('password.request')" wire:navigate>
                        {{ __('رمز عبور خود را فراموش کرده‌اید؟') }}
                    </flux:link>
                @endif
            </div>

            <!-- Remember Me -->
            <flux:checkbox name="remember" :label="__('مرا به خاطر بسپار')" :checked="old('remember')" />

            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full" data-test="login-button">
                    {{ __('ورود') }}
                </flux:button>
            </div>
        </form>

        <div class="flex items-center justify-center gap-1 text-sm text-center text-zinc-600 dark:text-zinc-400">
            <span>{{ __('حساب کاربری ندارید؟') }}</span>
            <flux:link :href="route('register')" wire:navigate>{{ __('ثبت‌نام') }}</flux:link>
        </div>
    </div>
</x-layouts::auth>
