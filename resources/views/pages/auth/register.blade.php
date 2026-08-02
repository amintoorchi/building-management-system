<x-layouts::auth :title="__('ثبت‌نام')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('ایجاد حساب کاربری')" :description="__('اطلاعات خود را برای ایجاد حساب کاربری وارد کنید')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6">
            @csrf
            <!-- Name -->
            <flux:input
                name="name"
                :label="__('نام کاربری')"
                :value="old('name')"
                type="text"
                required
                autofocus
                autocomplete="name"
                :placeholder="__('نام و نام خانوادگی')"
            />

            <!-- Phone Number -->
            <flux:input
                name="phone_number"
                :label="__('شماره موبایل')"
                :value="old('phone_number')"
                type="tel"
                required
                autocomplete="tel"
                placeholder="0914*******"
            />

            <!-- Password -->
            <flux:input
                name="password"
                :label="__('رمز عبور')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('رمز عبور')"
                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                viewable
            />

            <!-- Confirm Password -->
            <flux:input
                name="password_confirmation"
                :label="__('تکرار رمز عبور')"
                type="password"
                required
                autocomplete="new-password"
                :placeholder="__('تکرار رمز عبور')"
                passwordrules="{{ \Illuminate\Validation\Rules\Password::defaults()->toPasswordRulesString() }}"
                viewable
            />

            <div class="flex items-center justify-end">
                <flux:button type="submit" variant="primary" class="w-full" data-test="register-user-button">
                    {{ __('ایجاد حساب') }}
                </flux:button>
            </div>
        </form>

        <div class="flex items-center justify-center gap-1 text-center text-sm text-zinc-600 dark:text-zinc-400">
            <span>{{ __('قبلاً حساب کاربری ایجاد کرده‌اید؟') }}</span>
            <flux:link :href="route('login')" wire:navigate>{{ __('ورود') }}</flux:link>
        </div>
    </div>
</x-layouts::auth>
