<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Http\Controllers\Controller;
use App\Models\Permission;
use App\Models\Profile;
use Illuminate\Http\Request;

class PermissionProfileController extends Controller
{
    protected $profile, $permission;
    
    public function __construct(Profile $profile, Permission $permission)
    {
        $this->profile = $profile;
        $this->permission = $permission;
        $this->middleware(['can:profiles']);
    }
    
    /**
     * Retorna as permissões associadas a um perfil
     */
    public function permissions($idProfile)
    {
        $profile = $this->profile->find($idProfile);

        if(!$profile) {
            return redirect()->back();
        }

        $permissions = $profile->permissions()->paginate();

        return view('admin.pages.profiles.permissions.permissions', compact('profile','permissions'));
    }

    public function profiles($idPermission)
    {
        $permission = $this->permission->find($idPermission);

        if(!$idPermission) {
            return redirect()->back();
        }

        $profiles = $permission->profiles()->paginate();

        return view('admin.pages.permissions.profiles.profiles', compact('profiles','permission'));
    }

    /**
     * Recupera as permissões não associadas a um perfil para que o perfil adicione somente associação ao qual não está vinculado.
     */
    public function permissionsAvailable (Request $request, $idProfile)
    {
        if(!$profile = $this->profile->find($idProfile)) {
            return redirect()->back();
        }

        $filters = $request->except('_token');

        $permissions = $profile->permissionsAvailable($request->filter);

        return view('admin.pages.profiles.permissions.available', compact('profile', 'permissions', 'filters'));
    }

    /**
     * Associa uma ou mais permissões a um perfil
     */
    public function attachPermissionsProfile(Request $request, $idProfile)
    {
        if(!$profile = $this->profile->find($idProfile)) {
            return redirect()->back();
        }

        if(!$request->permissions || count($request->permissions) == 0) {
            return redirect()->back()->with('info', 'Você precisa selecionar uma permissão.');
        }

        $profile->permissions()->attach($request->permissions);

        return redirect()->route('profiles.permissions', $profile->id);
    }

    /**
     * Desvincula uma permissão de um perfil.
     */
    public function detachPermissionProfile($idProfile, $idPermission)
    {
        $profile = $this->profile->find($idProfile);
        $permission = $this->permission->find($idPermission);

        if(!$profile || !$permission) {
            return redirect()->back();
        }

        $profile->permissions()->detach($permission);

        return redirect()->route('profiles.permissions', $profile->id);
    }

}
