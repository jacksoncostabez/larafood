<?php

namespace App\Providers;

use App\Models\{
    User,
    Permission,
    Product
};
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //verifica se está rodando a aplicação via console. Se sim, retorna true e não executa abaixo!
        if ($this->app->runningInConsole()) return;

        $permissions = Permission::all();

        /**
         * Retorna para o usuário apenas as permissões associadas a ele.
         * Isso tem efeito na apliação colocando o nome das permissões
         * No menu do adminlte, basta colocar: 'can'  => 'profiles'
         * Logo, se essa permissão estiver dentro da verificação abaixo
         * o menu aparece para ele. Caso contrário, não aparece.
         * Aplicando só isso, ele ainda continua tendo acesso aos métodos dos
         * Controllers. Para impedir isso, basta aplicar o comando nos controllers:
         * $this->middleware(['can:categories']); -> para o CategoryController e assim
         * por diante.
         **/
        foreach ($permissions as $permission) {
            Gate::define($permission->name, function(User $user) use ($permission) {
                return $user->hasPermission($permission->name);
            });
        }

        /**
         * Verifica se o usuário é dono de um registro.
         */
        Gate::define('owner', function(User $user, $object) {
            return $user->id === $object->user_id;
        });

        /**
         * Verifica se o usuário logado é admin, antes de todos os outros Gates.
         * Se sim, ele não aplica as outras regras e deixa todos os menus liberados.
         * Caso não seja admin, ele aplica as regras acima.
         */
        Gate::before(function (User $user) {
            if($user->isAdmin()) {
                return true;
            }
        });
    }
}
