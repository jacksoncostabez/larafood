<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\Tenant;
use Illuminate\Database\Seeder;

class TenantsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plan = Plan::first();

        $plan->tenants()->create([
            'cnpj' => '21.925.256/0001-80',
            'name' => 'Jcb Empreedimentos',
            'url' => 'jcb-empreendimentos',
            'email' => 'contato@jcbempreedimentos.com.br',
        ]);
    }
}
