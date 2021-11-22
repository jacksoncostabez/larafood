<?php

namespace App\Tenant\Scopes;

use App\Tenant\ManagerTenant;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 * Esse escopo serve para filtrar pela tenant_id logado no sistema.
 * Para chamar esse método, a classe precisa usar o  use TenantTrait;
 * que automaticamente acionará o método booted que é onde ele chama uma
 * nova instância de TenantScope, static::addGlobalScope(new TenantScope); 
 * para cria um escopo global com a query abaixo. Ou seja, com tenant_id do
 * tenant logado no sistema.
 * Qualquer classe que precisar trazer os dados associados somente a tenant logada
 * no sistema, basta colocar o [ use TenantTrait;] assim como está em Category.php
 * 
 */
class TenantScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $identify = app(ManagerTenant::class)->getTenantIdentify();

        if ($identify)
            $builder->where('tenant_id', $identify);
    }
}
