<x-filament-widgets::widget>
    <x-filament::section>
        <x-filament::section.heading>Run Migrations</x-filament::section.heading>
        <x-filament::section.description>
            Run database migrations from the admin dashboard.
        </x-filament::section.description>
        <br />
        <x-filament::modal id="run-migrations-modal" teleport="body" width="lg">
            <x-slot name="trigger">
                <x-filament::button wire:click="runMigrations" wire:loading.attr="disabled" color="primary">
                    <span wire:loading class="animate-spin mr-2">▹</span>
                    Run
                </x-filament::button>
            </x-slot>

            <x-slot name="header">
                <h3 class="fi-modal-heading">Migration Output</h3>
            </x-slot>

            <div class="fi-modal-content">
                <pre class="whitespace-pre-wrap text-sm text-gray-800">{{ $output ?? 'No output yet.' }}</pre>
            </div>

            <x-slot name="footer">
                <x-filament::button x-on:click="$dispatch('close-modal', { id: 'run-migrations-modal' })" color="gray">Close</x-filament::button>
            </x-slot>
        </x-filament::modal>
    </x-filament::section>
</x-filament-widgets::widget>
