<?php

namespace App\Models\Traits;

trait UserACLTrait
{
    /**
     * Retorna as permissões do usuário autenticado.
     */
    public function permissions()
    {
        $tenant = $this->tenant()->first();
        $plan = $tenant->plan;

        $permissions = [];
        foreach($plan->profiles as $profile) {
            foreach ($profile->permissions as $permission) {
                array_push($permissions, $permission->name);
            }
        }

        return $permissions;
    }

    /**
     * Verifica se o usuário tem a permissão.
     */
    public function hasPermission(String $permissionName): bool
    {
        return in_array($permissionName, $this->permissions());
    }

    /**
     * Verifica se o usuário é um admin do sistema.
     */
    public function isAdmin(): bool
    {
        return in_array($this->email, config('acl.admins'));
    }

    /**
     * Verifica se o usuário é uma Tenant
     */
    public function isTenant(): bool
    {
        return !in_array($this->email, config('acl.admins'));
    }
}