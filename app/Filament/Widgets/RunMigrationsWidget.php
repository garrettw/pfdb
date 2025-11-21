<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\Artisan;

class RunMigrationsWidget extends Widget
{
    protected string $view = 'filament.widgets.run-migrations-widget';

    public $output = null;
    public $showModal = false;

    public function runMigrations(): void
    {
        $this->output = null;

        try {
            Artisan::call('migrate', ['--force' => true]);
            $this->output = Artisan::output() ?: 'Migrations completed.';
        } catch (\Throwable $e) {
            $this->output = 'Migration error: ' . $e->getMessage();
        }

        $this->showModal = true;
    }
}
