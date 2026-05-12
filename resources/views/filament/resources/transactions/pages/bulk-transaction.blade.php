<x-filament-panels::page>
    <x-filament::section>
        {{ $this->form }}
    </x-filament::section>

    <div class="flex justify-end mt-4">
        <x-filament::button
            color="success"
            wire:click="save"
            wire:loading.attr="disabled"
        >
            Save all transactions
        </x-filament::button>
    </div>
</x-filament-panels::page>