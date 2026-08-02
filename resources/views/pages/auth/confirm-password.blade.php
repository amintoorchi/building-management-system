<x-layouts::auth :title="__('تأیید رمز عبور')">
    <div class="flex flex-col gap-6">
        <x-auth-header
            :title="__('تأیید رمز عبور')"
            :description="__('این بخش امنی از برنامه است. لطفاً برای ادامه، رمز عبور خود را تأیید کنید.')"
        />

        <x-auth-session-status class="text-center" :status="session('status')" />

        <x-passkey-verify
            options-route="passkey.confirm-options"
            submit-route="passkey.confirm"
            :label="__('تأیید با کلید عبور')"
            :loading-label="__('در حال تأیید...')"
            :separator="__('یا با رمز عبور تأیید کنید')"
        />

        <form method="POST" action="{{ route('password.confirm.store') }}" class="flex flex-col gap-6">
            @csrf

            <flux:input
                name="password"
                :label="__('رمز عبور')"
                type="password"
                required
                autocomplete="current-password"
                :placeholder="__('رمز عبور')"
                viewable
            />

            <flux:button variant="primary" type="submit" class="w-full" data-test="confirm-password-button">
                {{ __('تأیید') }}
            </flux:button>
        </form>
    </div>
</x-layouts::auth>
