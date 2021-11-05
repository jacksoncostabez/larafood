<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Models\Plan;

class TenantService 
{
    private $plan, $data = [];

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
            'url' => Str::kebab($this->data['empresa']),
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
