<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\Table;

class TableObserver
{
    /**
     * Handle the Table "created" event.
     *
     * @param  \App\Models\Table  $table
     * @return void
     */
    public function creating(Table $table)
    {
        $table->uuid = Str::uuid();
    }
}
