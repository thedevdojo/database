<?php

return [

    /*
     * Tables hidden from the database browser.
     */
    'table-exclude' => [
        'migrations',
        'password_reset_tokens',
        'sessions',
        'cache',
        'cache_locks',
        'jobs',
        'job_batches',
        'failed_jobs',
    ],

    /*
     * Tables pinned to the top of the list, in order.
     */
    'table-order' => [
        'users',
    ],

    /*
     * Optional per-table searchable columns. Tables not listed here
     * fall back to searching across all of their columns.
     *
     * Example: 'users' => ['name', 'email'],
     */
    'searchable' => [],

];
