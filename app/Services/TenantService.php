<?php

namespace App\Services;

use App\Models\Plan;
use App\Repositories\Contracts\TenantRepositoryInterface;

class TenantService 
{
    private $plan, $data = [];
    private $repository;

    /**
     * Cria um objeto de TenantRepository, que implementa TenantRepositoryInterface
     * A conversão é feita no Providers\AppServiceProvider.php no método register();
     * Pois não é possível criar um objeto de uma interface.
     */
    public function __construct(TenantRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function getAllTenants()
    {
        return $this->repository->getAllTenants();
    }

    public function make(Plan $plan, array $data)
    {
        $this->plan = $plan;
        $this->data = $data;

        //cria o tenant (empresa)
        $tenant = $this->storeTenant();

        //Cria o usuário e associa a empresa acima.
        $user = $this->storeUser($tenant);

        return $user;
    }

    public function storeTenant()
    {
        return $this->plan->tenants()->create([
            'name' => $this->data['empresa'],
            'cnpj' => $this->data['cnpj'],
            //'url' => Str::kebab($this->data['empresa']), especificado no TenantObserver
            'email' => $this->data['email'],
            'subscription' => now(),
            'expires_at' => now()->addDays(7), //adiciona 7 dias após o dia atual.
        ]);
    }

    public function storeUser($tenant)
    {
        $user = $tenant->users()->create([
            'name' => $this->data['name'],
            'email' => $this->data['email'],
            'password' => bcrypt($this->data['password']),
        ]);

        return $user;
    }

}
