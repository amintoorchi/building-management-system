<?php

namespace App\Livewire\Pages;

use App\Models\User;
use Flux\Flux;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('افراد')]
class Users extends Component
{
    public string $name = '';

    public ?string $phone_number = '';

    public ?int $selectedUserId = null;

    public function confirmDelete(int $userId): void
    {
        $this->selectedUserId = $userId;

        Flux::modal('delete-user')->show();
    }

    public function delete(): void
    {
        if (! $this->selectedUserId) {
            return;
        }

        User::findOrFail($this->selectedUserId)->delete();

        $this->selectedUserId = null;

        Flux::modal('delete-user')->close();
    }

    public function resetForm(): void
    {
        $this->reset([
            'name',
            'phone_number',
        ]);
    }

    public function save(): void
    {
        $validated = $this->validate([
            'name' => ['nullable'],
            'phone_number' => ['nullable', 'string', 'max:255'],
        ]);

        User::create($validated);

        $this->resetForm();

        Flux::modal('add-user')->close();

        Flux::toast(
            heading: 'فرد جدید ثبت شد',
            text: 'فرد جدید با موفقیت ثبت گردید ',
            variant: 'success',
        );
    }

    #[Computed]
    public function users()
    {
        return User::latest()->get();
    }

    #[Computed]
    public function count()
    {
        return User::count();
    }

    public function render()
    {
        return view('pages.users');
    }
}
