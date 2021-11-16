<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;

class RoleUserController extends Controller
{
    protected $role, $user;

    public function __construct(User $user, Role $role)
    {
        $this->role = $role;
        $this->user = $user;

        $this->middleware(['can:users']);
    }

    /**
     * Recupera os cargos não associados aos perfis.
     */
    public function usersAvailable(Request $request, $idRole)
    {
        if (!$role = $this->role->find($idRole)) {
            return redirect()->back();
        }

        $filters = $request->except('_token');

        $users = $role->usersAvailable($request->filter);

        return view('admin.pages.roles.users.available', compact('role', 'users', 'filters'));
    }

    /**
     * Vincula um usuário a um cargo.
    */
    public function attachUsersRole(Request $request, $idRole)
    {
        if (!$role = $this->role->find($idRole)) {
            return redirect()->back();
        }

        if (!$request->users || count($request->users) == 0) {
            return redirect()->back()->with('info', 'Você precisa selecionar um usuário.');
        }

        $role->users()->attach($request->users);

        return redirect()->route('roles.users', $role->id);
    }

    /**
     * Desvincula um cargo de um usuário
     */
    public function detachUserRole($idRole, $idUser)
    {
        $role = $this->role->find($idRole);
        $user = $this->user->find($idUser);

        if (!$role || !$user) {
            return redirect()->back();
        }

        $role->users()->detach($user);

        return redirect()->route('roles.users', $user->id);
    }

    /**
     * =================================--- Roles x Users (Especializa TI) --=====================================
     */

    /**
     * Retorna os usuários associados a um cargo.
     */
    public function users($idRole)
    {
        if (!$role = $this->role->find($idRole)) {
            return redirect()->back();
        }

        $users = $role->users()->paginate();

        return view('admin.pages.roles.users.users', compact('role', 'users'));
    }

    /**
     * Retorna os cargos associados a um perfil.
     */
    public function roles($idUser)
    {
        $user = $this->user->find($idUser);

        if (!$user) {
            return redirect()->back();
        }

        $roles = $user->roles()->paginate();

        return view('admin.pages.users.roles.roles', compact('user', 'roles'));
    }

    /**
     * Vincula um cargo a um usuário.
     */
    public function attachRolesUser(Request $request, $idUser)
    {
        if (!$user = $this->user->find($idUser)) {
            return redirect()->back();
        }

        if (!$request->roles || count($request->roles) == 0) {
            return redirect()
                ->back()
                ->with('info', 'Precisa escolher pelo menos uma permissão');
        }

        $user->roles()->attach($request->roles);

        return redirect()->route('users.roles', $user->id);
    }

    /**
     * Recupera os usuários não associados a cargos
     */
    public function rolesAvailable(Request $request, $idUser)
    {
        if (!$user = $this->user->find($idUser)) {
            return redirect()->back();
        }

        $filters = $request->except('_token');

        $roles = $user->rolesAvailable($request->filter);

        return view('admin.pages.users.roles.available', compact('user', 'roles', 'filters'));
    }

    /**
     * Desvincula um usuário de um cargo.
     */
    public function detachRoleUser($idUser, $idRole)
    {
        $user = $this->user->find($idUser);
        $role = $this->role->find($idRole);

        if (!$user || !$role) {
            return redirect()->back();
        }

        $user->roles()->detach($role);

        return redirect()->route('users.roles', $user->id);
    }
}
