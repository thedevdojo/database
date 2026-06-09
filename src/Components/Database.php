<?php

namespace DevDojo\Database\Components;

use DevDojo\Database\Support\TableManager;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Database extends Component
{
    use WithPagination;

    public string $table = 'users';

    public string $search = '';

    public int $paginate = 15;

    public string $sortColumn = 'id';

    public string $sortDirection = 'asc';

    public mixed $primaryKeyValue = null;

    public string $primaryKey = 'id';

    /** @var array<string, mixed>|null */
    public ?array $entryArray = null;

    public function sortBy(string $column): void
    {
        if ($this->sortColumn === $column) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';

            return;
        }

        $this->sortColumn = $column;
        $this->sortDirection = 'asc';
    }

    #[On('selectTable')]
    public function selectTable(string $table): void
    {
        $this->primaryKeyValue = null;
        $this->entryArray = null;
        $this->table = $table;
        $this->resetPage();
    }

    #[On('loadEntry')]
    public function loadEntry(mixed $value): void
    {
        $this->primaryKeyValue = $value;
        $record = $this->getEntryRecord();
        $this->entryArray = $record ? (array) $record : null;
    }

    public function saveEntry(): void
    {
        $record = $this->getEntryRecord();

        if ($record) {
            foreach ($record as $column => $item) {
                if (array_key_exists($column, $this->entryArray) && $item != $this->entryArray[$column]) {
                    DB::table($this->table)
                        ->where($this->primaryKey, $this->primaryKeyValue)
                        ->update([$column => $this->entryArray[$column]]);
                }
            }
        }

        $this->dispatch('hide-entry-editor');
        $this->dispatch('entry-saved');
    }

    /** @return array<int, string> */
    public function getTableColumnsProperty(): array
    {
        return app(TableManager::class)->columns($this->table);
    }

    private function getEntryRecord(): ?object
    {
        if (is_null($this->primaryKeyValue)) {
            return null;
        }

        return DB::table($this->table)
            ->where($this->primaryKey, $this->primaryKeyValue)
            ->first();
    }

    public function render()
    {
        $columns = $this->tableColumns;

        $data = DB::table($this->table);

        if ($this->search !== '') {
            $searchable = config('devdojo-database.searchable')[$this->table] ?? $columns;

            $data->where(function ($query) use ($searchable) {
                foreach ($searchable as $column) {
                    $query->orWhere($column, 'like', '%'.$this->search.'%');
                }
            });
        }

        $data = $data->orderBy($this->sortColumn, $this->sortDirection)->select($columns);

        return view('database::Components.database', [
            'tableData' => $data->paginate($this->paginate),
        ]);
    }
}
