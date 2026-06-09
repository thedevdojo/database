<?php

namespace DevDojo\Database\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TableManager
{
    /**
     * Table names visible in the browser, excluded/reordered per config.
     *
     * @return array<int, string>
     */
    public function tableNames(): array
    {
        $excluded = config('devdojo-database.table-exclude', []);

        $tables = array_values(array_diff(Schema::getTableListing(schemaQualified: false), $excluded));

        return $this->reorder($tables);
    }

    /**
     * Table names with their row counts.
     *
     * @return Collection<int, array{name: string, rows: int}>
     */
    public function tables(): Collection
    {
        return collect($this->tableNames())->map(fn (string $name): array => [
            'name' => $name,
            'rows' => DB::table($name)->count(),
        ]);
    }

    /**
     * Column names for a given table.
     *
     * @return array<int, string>
     */
    public function columns(string $table): array
    {
        return Schema::getColumnListing($table);
    }

    /**
     * Pin configured tables to the front, in order.
     *
     * @param  array<int, string>  $tables
     * @return array<int, string>
     */
    private function reorder(array $tables): array
    {
        $ordered = [];

        foreach (config('devdojo-database.table-order', []) as $table) {
            $key = array_search($table, $tables, true);
            if ($key !== false) {
                $ordered[] = $table;
                unset($tables[$key]);
            }
        }

        return array_merge($ordered, array_values($tables));
    }
}
