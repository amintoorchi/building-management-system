<x-layouts::auth :title="__('بازنشانی رمز عبور')">
    <div class="flex flex-col gap-6">
        <x-auth-header :title="__('بازنشانی رمز عبور')" :description="__('لطفاً رمز عبور جدید خود را وارد کنید')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('password.update') }}" class="flex flex-col gap-6">
            @csrf
            <!-- Token -->
            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            <!-- Email Address -->
            <flux:input
                name="email"
                value="{{ request('email') }}"
                :label="__('ایمیل')"
                type="email"
                required
                autocomplete="email"
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
                <flux:button type="submit" variant="primary" class="w-full" data-test="reset-password-button">
                    {{ __('بازنشانی رمز عبور') }}
                </flux:button>
            </div>
        </form>
    </div>
</x-layouts::auth>
