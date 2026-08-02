<?php

namespace App\Livewire\Pages;

use App\Models\Unit;
use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('واحد ها')]
class Units extends Component
{
    public ?string $user_id = null;
    public string $home_number = '';

    public string $floor = '';
    public string $status = 'occupied';

    public string $plate_number = '';

    public function resetForm(): void
    {
        $this->reset([
            'user_id',
            'plate_number',
            'floor',
            'home_number',
            'status',
        ]);
    }

    public function save(): void
    {
        $validated = $this->validate([
            'user_id' => ['nullable'],
            'home_number' => ['nullable', 'string', 'max:255'],
            'floor' => ['nullable', 'string', 'max:255'],
            'status' => ['string', 'max:255'],
            'plate_number' => ['required', 'string', 'max:255'],
        ]);


        $this->user_id = $this->user_id ?: null;

        Unit::create($validated);

        $this->resetForm();

        Flux::modal('add-unit')->close();

        Flux::toast(
            heading: 'واحد جدید ثبت شد ',
            text: 'واحد جدید با موفقیت ثبت گردید ',
            variant: 'success',
        );
    }

    #[Computed]
    public function users()
    {
        return User::latest()->get();
    }

    #[Computed]
    public function units()
    {
        return Unit::latest()->get();
    }

    #[Computed]
    public function count()
    {
        return Unit::count();
    }

    public function render()
    {
        return view('pages.units');
    }
}
