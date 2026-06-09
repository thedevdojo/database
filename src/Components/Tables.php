<?php

namespace DevDojo\Database\Components;

use DevDojo\Database\Support\TableManager;
use Livewire\Component;

class Tables extends Component
{
    /** @var array<int, string> */
    public array $tables = [];

    public string $table = 'users';

    public function mount(): void
    {
        $this->tables = app(TableManager::class)->tableNames();
    }

    public function render()
    {
        return view('database::Components.tables');
    }
}
