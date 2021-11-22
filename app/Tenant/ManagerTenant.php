<?php

namespace App\Tenant;

use App\Models\Tenant;

class ManagerTenant
{
    /**
     * Get id tenant do user logado caso ele exista. O caso de não existir é para o usuário que apenas sentar na mesa
     */
    public function getTenantIdentify()
    {
        return auth()->check() ? auth()->user()->tenant_id : '';
    }

    /**
     * get tenant logged
     */
    public function getTenant()
    {
        return auth()->check() ? auth()->user()->tenant : '';
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
