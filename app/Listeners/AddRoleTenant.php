<?php

namespace App\Listeners;

use App\Models\Role;
use App\Tenant\Events\TenantCreated;

class AddRoleTenant
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(TenantCreated $event)
    {
        $user = $event->user();

        if (!$role = Role::first()) {
            return;
        }

        $user->roles()->attach($role);

        return 1;
    }
}
