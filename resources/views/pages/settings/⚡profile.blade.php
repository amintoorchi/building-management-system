<?php

use App\Concerns\ProfileValidationRules;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('تنظیمات پروفایل')] class extends Component {
    use ProfileValidationRules;

    public string $name = '';
    public string $phone_number = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->phone_number = Auth::user()->phone_number;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate($this->profileRules($user->id));

        $user->fill($validated);
        $user->save();

        Flux::toast(
            variant: 'success',
            text: __('پروفایل با موفقیت به‌روزرسانی شد.')
        );
    }

    #[Computed]
    public function showDeleteUser(): bool
    {
        return true;
    }
}; ?>

<section class="w-full p-5">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('تنظیمات پروفایل') }}</flux:heading>

    <x-pages::settings.layout :heading="__('پروفایل')" :subheading="__('نام و نشانی ایمیل خود را به‌روزرسانی کنید')">
        <form wire:submit="updateProfileInformation" class="my-6 w-full space-y-6">
            <flux:input wire:model="name" :label="__('نام')" type="text" required autofocus autocomplete="name" />

            <div>
                <flux:input wire:model="phone_number" :label="__('شماره تلفن')" type="tel" required
                    autocomplete="tel" />
            </div>

            <div class="flex items-center gap-4">
                <div class="flex items-center justify-end">
                    <flux:button variant="primary" type="submit" class="w-full" data-test="update-profile-button">
                        {{ __('ذخیره') }}
                    </flux:button>
                </div>

            </div>
        </form>

        @if ($this->showDeleteUser)
            <livewire:pages::settings.delete-user-form />
        @endif
    </x-pages::settings.layout>
</section>