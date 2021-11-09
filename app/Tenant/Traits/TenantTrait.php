<?php

namespace App\Tenant\Traits;

use App\Tenant\Observers\TenantObserver;

trait TenantTrait
{
    /**
     * Método usado para chamar o outro Observer de Tenant, App\Tenant\TenantObserver.php
     * que retorna o id da company do usuário logado para inserir automaticamente no momento
     * em que estiver criando uma nova categoria. Ou seja, não precisa fazer uma busca pelo id
     * da company na hora de inserir uma categoria, ele pega automaticamente.
     */
    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    public static function booted()
    {
        parent::boot();

        static::observe(TenantObserver::class);
    }
}
