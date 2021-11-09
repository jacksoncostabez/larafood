<?php

namespace App\Tenant;

use App\Models\Tenant;

class ManagerTenant
{
    /**
     * Get id tenant do user logado.
     */
    public function getTenantIdentify()
    {
        return auth()->user()->tenant_id;
    }

    /**
     * get tenant logged
     */
    public function getTenant(): Tenant
    {
        return auth()->user()->tenant;
    }

    /**
     * tenant está se referindo ao config/tenant.php
     * O método em si, verifica se o usuário é autenticado ou não.
     */
    public function isAdmin(): bool
    {
        return in_array(auth()->user()->email, config('tenant.admins'));
    }
}
