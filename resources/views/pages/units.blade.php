<div class="p-5" dir="">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">{{ __('واحد های آپارتمان') }}</flux:heading>
        <flux:subheading size="lg" class="mb-6">{{ __('مدیریت و کنترل واحد های آپارتمان') }}</flux:subheading>
        <flux:separator variant="subtle" />


        <flux:modal name="add-unit" class="w-md md:w-2xl" wire:close="resetForm">
            <form wire:submit="save" class="space-y-6">

                <div>
                    <flux:heading size="lg">
                        افزودن واحد جدید
                    </flux:heading>

                    <flux:subheading>
                        اطلاعات واحد جدید را وارد کنید.
                    </flux:subheading>
                </div>

                <div class="grid grid-cols-2 gap-4">

                    {{-- Resident --}}
                    <flux:select wire:model="user_id" label="ساکن / مالک واحد" placeholder="انتخاب نشده">
                        <flux:select.option value="">
                            بدون ساکن/مالک
                        </flux:select.option>

                        @foreach ($this->users as $user)
                            <flux:select.option value="{{ $user->id }}">
                                {{ $user->name }}
                            </flux:select.option>
                        @endforeach
                    </flux:select>

                    {{-- Unit Number --}}
                    <flux:input wire:model.blur="plate_number" label="شماره پلاک واحد" placeholder="مثلاً ۳"
                        inputmode="numeric" />

                    {{-- Floor --}}
                    <flux:input wire:model.blur="floor" label="طبقه" placeholder="مثلاً ۲" inputmode="numeric" />

                    {{-- Landline --}}
                    <flux:input wire:model.blur="home_number" label="شماره تلفن ثابت" placeholder="۰۴۱۳۴۴....."
                        type="tel" inputmode="tel" autocomplete="tel" />

                </div>

                <div class="flex justify-end gap-2 pt-2">

                    <flux:modal.close>
                        <flux:button variant="ghost">
                            انصراف
                        </flux:button>
                    </flux:modal.close>

                    <flux:button type="submit" variant="primary" wire:loading.attr="disabled">
                        <span wire:loading.remove wire:target="save">
                            افزودن واحد
                        </span>

                        <span wire:loading wire:target="save">
                            در حال افزودن...
                        </span>
                    </flux:button>

                </div>

            </form>
        </flux:modal>

    </div>

    <div class="container max-w-screen-xl mx-auto mt-10">

        <div class="grid auto-rows-min gap-4 md:grid-cols-3">

            <div class="overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                <div class="flex gap-2 items-center">
                    <flux:icon.building-office-2 variant="micro" class="text-blue-600 dark:text-blue-500" />
                    <flux:text>تعداد کل واحد ها</flux:text>
                </div>

                <flux:heading size="xl" class="mt-2">
                    {{ $this->count }}
                </flux:heading>

                <div class="mt-2 flex items-center gap-2">
                    <span class="text-sm text-neutral-500">
                        تعداد واحد های ثبت شده
                    </span>
                </div>
            </div>


            <div class="overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                <div class="flex gap-2 items-center">
                    <flux:icon.building-office variant="micro" class="text-blue-600 dark:text-blue-500" />
                    <flux:text>تعداد واحد های اشغال شده</flux:text>
                </div>

                <flux:heading size="xl" class="mt-2">
                    10
                </flux:heading>

                <div class="mt-2 flex items-center gap-2">
                    <flux:icon.check-circle variant="micro" class="text-green-600 dark:text-green-500" />

                    <span class="text-sm text-green-600 dark:text-green-500">
                        ۸۰٪
                    </span>
                </div>
            </div>


            <div class="overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
                <flux:text>بدهی ها</flux:text>

                <flux:heading size="xl" class="mt-2">
                    48
                </flux:heading>

                <div class="mt-2 flex items-center gap-2">
                    <flux:icon.cube variant="micro" class="text-purple-600 dark:text-purple-500" />

                    <span class="text-sm text-neutral-500">
                        بدهی های مانده
                    </span>
                </div>
            </div>

        </div>



        <div class="mt-10">
            <flux:modal.trigger name="add-unit">
                <flux:button>افزودن واحد جدید</flux:button>
            </flux:modal.trigger>
        </div>


        <div
            class="overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 px-4 py-4 mt-5 sm:px-7">

            @if ($this->units->count() > 0)

                <div class="overflow-x-auto">
                    <flux:table class="min-w-full m-auto">

                        <flux:table.columns>
                            <flux:table.column>نام ساکن</flux:table.column>
                            <flux:table.column>شماره پلاک</flux:table.column>
                            <flux:table.column>وضعیت</flux:table.column>
                            <flux:table.column>شماره تلفن ثابت</flux:table.column>
                            <flux:table.column align="left">جزئیات</flux:table.column>
                        </flux:table.columns>

                        <flux:table.rows>
                            @foreach ($this->units as $unit)
                                @php
                                    $statusColor = match ($unit->status) {
                                        'occupied' => 'green',
                                        'vacant' => 'red',
                                        'unknown' => 'zinc',
                                    // default => 'zinc',
                                    };
                                @endphp
                                <flux:table.row :key="$unit->id">

                                    <flux:table.cell class="flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                        </svg>
                                        <span class="whitespace-nowrap font-mono">{{ $unit->user?->name ?? 'بدون ساکن / ثبت نشده' }}</span>

                                    </flux:table.cell>

                                   <flux:table.cell class="whitespace-nowrap">
                                        <flux:badge size="sm" color="indigo">
                                            {{ ucfirst($unit->plate_number) }}
                                        </flux:badge>
                                    </flux:table.cell>

                                    <flux:table.cell class="whitespace-nowrap">
                                        <flux:badge size="sm" :color="$statusColor">
                                            {{ ucfirst($unit->status) }}
                                        </flux:badge>
                                    </flux:table.cell>

                                    <flux:table.cell class="whitespace-nowrap">
                                        <flux:badge size="sm" color="indigo">
                                            {{ ucfirst($unit->home_number) }}
                                        </flux:badge>
                                    </flux:table.cell>

                                    <flux:table.cell align="left">
                                        <flux:button icon="adjustments-horizontal" square size="sm" tooltip="گزارشات و جزئیات واحد"
                                            href="{{ route('units', $unit->id) }}" wire:navigate />
                                    </flux:table.cell>

                                </flux:table.row>
                            @endforeach
                        </flux:table.rows>

                    </flux:table>
                </div>

            @else

                {{-- Empty state --}}
                <div class="flex flex-col items-center justify-center gap-4 py-16 text-center">
                    <div
                        class="flex h-14 w-14 items-center justify-center rounded-xl border border-dashed border-zinc-300 dark:border-zinc-700">
                        <flux:icon.building-office-2 class="size-6 text-zinc-400 dark:text-zinc-600" />
                    </div>

                    <div class="space-y-1">
                        <flux:heading size="md">واحدی ثبت نشده است</flux:heading>
                        <flux:text class="text-zinc-500">
                            با فشردن ‍‍`افزودن واحد جدید` یک واحد ثبت کنید
                        </flux:text>
                    </div>

                    <flux:modal.trigger name="add-unit">
                        <flux:button icon="plus" variant="primary" size="sm">
                            افزودن واحد جدید
                        </flux:button>
                    </flux:modal.trigger>
                </div>

            @endif

        </div>

    </div>
</div>