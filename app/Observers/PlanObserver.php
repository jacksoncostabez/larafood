<?php

namespace App\Observers;

use Illuminate\Support\Str;
use App\Models\Plan;

class PlanObserver
{
    /**
     * Handle the Plan "creating" event.
     *
     * @param  \App\Models\Plan  $plan
     * @return void
     */
    //creating -> quer dizer que essa execução vai ser feita antes de criar o plano.
    //Ou seja, antes de criar o plano ele pega a url inserida e faz a formatação com o kebab
    public function creating(Plan $plan)
    {
        $plan->url = Str::kebab($plan->name);
    }

    /**
     * Handle the Plan "updating" event.
     *
     * @param  \App\Models\Plan  $plan
     * @return void
     */
    public function updating(Plan $plan)
    {
        $plan->url = Str::kebab($plan->name);
    }

}
