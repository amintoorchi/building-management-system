<div class="p-5">
    <div class="relative mb-6 w-full">
        <flux:heading size="xl" level="1">
            {{ __('افراد ساختمان') }}
        </flux:heading>

        <flux:subheading size="lg" class="mb-6">
            {{ __('مدیریت و کنترل افراد ساکن و مالک در ساختمان') }}
        </flux:subheading>

        <flux:separator variant="subtle" />
    </div>



    <flux:modal name="add-user" class="w-md md:w-2xl" wire:close="resetForm">
        <form wire:submit="save" class="space-y-6">

            <div>
                <flux:heading size="lg">
                    ثبت فرد جدید
                </flux:heading>

                <flux:subheading>
                    اطلاعات فرد جدید را وارد نمائید.
                </flux:subheading>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <flux:input wire:model.blur="name" label="نام و نام خانوادگی" placeholder="علی ...." />
                <flux:input wire:model.blur="phone_number" label="شماره تلفن همراه" placeholder=".......۰۹۳۹"
                    inputmode="numeric" />
            </div>

            <div class="flex justify-end gap-2 pt-2">

                <flux:modal.close>
                    <flux:button variant="ghost">
                        انصراف
                    </flux:button>
                </flux:modal.close>

                <flux:button type="submit" variant="primary" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="save">
                        افزودن فرد
                    </span>

                    <span wire:loading wire:target="save">
                        در حال افزودن...
                    </span>
                </flux:button>

            </div>

        </form>
    </flux:modal>



    <div class="container max-w-screen-xl mx-auto mt-10">

        <div class="mt-10">
            <flux:modal.trigger name="add-user">
                <flux:button>افزودن فرد جدید</flux:button>
            </flux:modal.trigger>
        </div>


        <div
            class="overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 px-4 py-4 mt-5 sm:px-7">

            @if ($this->users->count() > 0)

                <div class="overflow-x-auto">

                    <flux:table class="min-w-full m-auto">

                        <flux:table.columns>

                            <flux:table.column>
                                نام
                            </flux:table.column>

                            <flux:table.column>
                                شماره تلفن همراه
                            </flux:table.column>

                            <flux:table.column>
                                متعلق به
                            </flux:table.column>

                            <flux:table.column align="center">
                                عملیات
                            </flux:table.column>

                        </flux:table.columns>


                        <flux:table.rows>

                            @foreach ($this->users as $user)

                                <flux:table.row :key="$user->id">

                                    {{-- Name --}}
                                    <flux:table.cell class="flex items-center gap-2">

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                        </svg>

                                        <span class="whitespace-nowrap font-mono">
                                            {{ $user->name }}
                                        </span>

                                    </flux:table.cell>


                                    {{-- Phone --}}
                                    <flux:table.cell class="whitespace-nowrap">

                                        @if ($user->phone_number)

                                            <flux:badge size="sm" color="indigo">
                                                {{ $user->phone_number }}
                                            </flux:badge>

                                        @else

                                            <flux:badge size="sm" color="zinc">
                                                ثبت نشده
                                            </flux:badge>

                                        @endif

                                    </flux:table.cell>

                                    <flux:table.cell class="whitespace-nowrap">
                                        @if ($user->units->isNotEmpty())

                                            @foreach ($user->units as $unit)
                                                <flux:badge size="sm" color="amber">
                                                    پلاک : {{ $unit->plate_number }}
                                                </flux:badge>
                                            @endforeach

                                        @else

                                            <flux:badge size="sm" color="zinc">
                                                ثبت نشده
                                            </flux:badge>

                                        @endif
                                    </flux:table.cell>


                                    {{-- Actions --}}
                                    <flux:table.cell align="center">

                                        <flux:button icon="pencil" square variant="outline" size="sm"
                                            tooltip="ویرایش اطلاعات فرد" href="{{ route('units', $user->id) }}" wire:navigate />

                                        <flux:button variant="danger" square size="sm" icon="trash" tooltip="حذف فرد"
                                            wire:click="confirmDelete({{ $user->id }})" />

                                    </flux:table.cell>

                                </flux:table.row>

                            @endforeach

                            <flux:modal name="delete-user" class="w-[28rem]">

                                <div class="space-y-6">

                                    <div>
                                        <flux:heading size="lg">
                                            حذف فرد
                                        </flux:heading>

                                        <flux:text class="mt-2">
                                            آیا از حذف این فرد اطمینان دارید؟
                                            <br>
                                            اطلاعات این فرد قابل بازیابی نخواهد بود.
                                        </flux:text>
                                    </div>

                                    <div class="flex justify-end gap-2">

                                        <flux:modal.close>
                                            <flux:button variant="ghost">
                                                لغو
                                            </flux:button>
                                        </flux:modal.close>

                                        <flux:button type="button" variant="danger" wire:click="delete"
                                            wire:loading.attr="disabled" wire:target="delete">

                                            <span wire:loading.remove wire:target="delete">
                                                از حذف فرد اطمینان دارم
                                            </span>

                                            <span wire:loading wire:target="delete">
                                                در حال حذف...
                                            </span>

                                        </flux:button>

                                    </div>

                                </div>

                            </flux:modal>

                        </flux:table.rows>

                    </flux:table>

                </div>


            @else

                {{-- Empty state --}}
                <div class="flex flex-col items-center justify-center gap-4 py-16 text-center">

                    <div
                        class="flex h-14 w-14 items-center justify-center rounded-xl border border-dashed border-zinc-300 dark:border-zinc-700">
                        <flux:icon.users class="size-6 text-zinc-400 dark:text-zinc-600" />
                    </div>

                    <div class="space-y-1">

                        <flux:heading size="md">
                            فردی ثبت نشده است
                        </flux:heading>

                        <flux:text class="text-zinc-500">
                            با فشردن `افزودن فرد جدید` یک فرد به ساختمان اضافه کنید
                        </flux:text>

                    </div>

                    <flux:modal.trigger icon="plus" name="add-user">
                        <flux:button>افزودن فرد جدید</flux:button>
                    </flux:modal.trigger>

                </div>

            @endif

        </div>

    </div>
</div>