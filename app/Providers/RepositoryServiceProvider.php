<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repositories\Contracts\{
    TenantRepositoryInterface
};
use App\Repositories\{
    TenantRepository
};

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Quando for injetado o TenantRepositoryInterface como objeto, ele cria um objeto da classe
         * TenantRepository. Isso porque não é possível criar um objeto de interface! Mas, como o
         * tornamos obrigatório a criação dos métodos dessa interface em TenantService, passando a 
         * interface no construtor. Então precisamos usar esse método abaixo! Que ao ser chamada a interface
         * no construtor ele cria um objeto de TenantRepository, que por sua vez implementa a interface
         * TenantRepositoryInterface.
         */
        $this->app->bind(
            TenantRepositoryInterface::class,
            TenantRepository::class,
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
