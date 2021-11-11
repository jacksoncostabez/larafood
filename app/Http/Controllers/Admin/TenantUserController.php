<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUpdateTenantUser;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;

class TenantUserController extends Controller
{
    public function __construct(Tenant $tenant, User $user)
    {
        $this->tenant = $tenant;
        $this->user = $user;
        $this->middleware(['can:tenants']);
    }

    /**
     * Retorna os usuários associados a uma empresa
     */
    public function users($idTenant)
    {
        $tenant = $this->tenant->find($idTenant);

        if(!$tenant) {
            return redirect()->back();
        }

        $users = $tenant->users()->paginate();

        return view('admin.pages.tenants.users.users', compact('tenant', 'users'));
    }

    public function create($idTenant)
    {
        if(!$tenant = $this->tenant->find($idTenant)){
            return redirect()->back();
        }

        return view('admin.pages.tenants.users.create', compact('tenant'));
    }

    public function store(StoreUpdateTenantUser $request, $idTenant)
    {
        if(!$tenant = $this->tenant->find($idTenant)){
            return redirect()->back();
        }

        $data = $request->all();
        $data['password'] = bcrypt($data['password']);

        $tenant->users()->create($data);

        return redirect()->route('tenants.users', $tenant->id);
    }

    public function edit($idUser, $idTenant)
    {
        $user = $this->user->find($idUser);
        $tenant = $this->tenant->find($idTenant);

        if (!$tenant || !$user) {
            return redirect()->back();
        }

        return view('admin.pages.tenants.users.edit', compact('user', 'tenant'));
    }

    public function update(StoreUpdateTenantUser $request, $idUser, $idTenant)
    {
        $user = $this->user->find($idUser);
        $tenant = $this->tenant->find($idTenant);

        if (!$tenant || !$user) {
            return redirect()->back();
        }

        $data = $request->only('name', 'email');

        if($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);

        return redirect()->route('tenants.users', $tenant->id);
    }

    public function destroy($idUser, $idTenant)
    {
        $user = $this->user->find($idUser);
        $tenant = $this->tenant->find($idTenant);
       
        if (!$tenant || !$user) {
            return redirect()->back();
        }

        $user->delete();

        return redirect()->route('tenants.users', $tenant->id)->with('message', 'Registro deletado com sucesso.');
    }
}
