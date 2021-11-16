<?php

namespace App\Models\Traits;

use App\Models\Role;
use App\Models\Tenant;

trait UserACLTrait
{
    /**
     * Retorna as permissões do usuário autenticado.
     */
    /*
    public function permissions()
    {
        $tenant = $this->tenant()->first();;
        $plan = $tenant->plan;

        $permissions = [];

        foreach ($plan->profiles as $profile) {
            foreach ($profile->permissions as $permission) {
                array_push($permissions, $permission->name);
            }
            $permissions[] = $profile->name;
        }

        return $permissions;
    }
    */


    /**
     * Método usado parra verificar se a permissão do cargo está dentro da permissão do plano.
     * Se tiver, ele add ao array de permissões para liberar as funcionalidades do usuário.
     */
    public function permissions(): array
    {
      //  dd($this->permissionsRole());
        $permissionsPlan = $this->permissionsPlan();
        $permissionsRole = $this->permissionsRole();

        $permissions = [];

        foreach ($permissionsRole as $permission) {
            if (in_array($permission, $permissionsPlan)) { //verifica se a permissão do cargo está na permissão do plano.
                array_push($permissions, $permission);
            }
        }

     //   dd($permissions);

        return $permissions;
    }

    /**
     * Retorna as permissões do plano
     */
    public function permissionsPlan(): array
    {
        $tenant = Tenant::with('plan.profiles.permissions')->where('id', $this->tenant_id)->first();
        $plan = $tenant->plan;

        $permissions = [];
        foreach ($plan->profiles as $profile) {
            foreach ($profile->permissions as $permission) {
                array_push($permissions, $permission->name);
            }
        }

        return $permissions;
    }

    /**
     * Retorna as permissões dos cargos do usuário.
     */
    public function permissionsRole(): array
    {
        if (!$role = Role::first()) {
            return 0;
        }

        $roles = $this->roles()->with('permissions')->get();

        //Se não tiver nenhum cargo, add o cargo padrão.
        if (count($roles) == 0) {
            $this->roles()->attach($role);
            $roles = $this->roles()->with('permissions')->get();
        }

        $permissions = [];
        foreach ($roles as $role) {
            foreach ($role->permissions as $permission) {
                array_push($permissions, $permission->name);
            }
            // $permissions [] = $role->name;
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
     * Verifica se o usuário autenticado é um admin do sistema.
     */
    public function isAdmin(): bool
    {
        return in_array($this->email, config('acl.admins'));
    }

    /**
     * Verifica se o usuário é Admin ou não.
     */
    public function isTenant(): bool
    {
        return !in_array($this->email, config('acl.admins'));
    }
}
