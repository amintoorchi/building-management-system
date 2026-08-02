<x-layouts::auth :title="__('تأیید ایمیل')">
    <div class="mt-4 flex flex-col gap-6">
        <flux:text class="text-center">
            {{ __('لطفاً با کلیک روی لینکی که به ایمیل شما ارسال کرده‌ایم، آدرس ایمیل خود را تأیید کنید.') }}
        </flux:text>

        @if (session('status') == 'verification-link-sent')
            <flux:text class="text-center font-medium !dark:text-green-400 !text-green-600">
                {{ __('یک لینک تأیید جدید به آدرس ایمیلی که هنگام ثبت‌نام وارد کرده‌اید ارسال شد.') }}
            </flux:text>
        @endif

        <div class="flex flex-col items-center justify-between gap-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <flux:button type="submit" variant="primary" class="w-full">
                    {{ __('ارسال مجدد ایمیل تأیید') }}
                </flux:button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <flux:button variant="ghost" type="submit" class="text-sm cursor-pointer" data-test="logout-button">
                    {{ __('خروج از حساب') }}
                </flux:button>
            </form>
        </div>
    </div>
</x-layouts::auth>
