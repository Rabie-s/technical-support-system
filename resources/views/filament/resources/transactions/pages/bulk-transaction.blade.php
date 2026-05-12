<x-filament-panels::page>
    <form wire:submit="save">
        <x-filament::section>
            {{ $this->form }}

            <x-slot name="footer">
                <x-filament::button type="submit">
                    Save Bulk Transaction
                </x-filament::button>
            </x-slot>
        </x-filament::section>
    </form>
</x-filament-panels::page>