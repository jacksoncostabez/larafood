<?php

namespace App\Http\Controllers\Admin\ACL;

use App\Http\Controllers\Controller;
use App\Models\Plan;
use App\Models\Profile;
use Illuminate\Http\Request;

class PlanProfileController extends Controller
{
    protected $plan, $profile;

    public function __construct(Plan $plan, Profile $profile)
    {
        $this->plan = $plan;
        $this->profile = $profile;
    }

    /**
     * Retorna as permissões associadas a um perfil
     */
    public function profiles($idPlan)
    {
        if (!$plan = $this->plan->find($idPlan)) {
            return redirect()->back();
        }

        $profiles = $plan->profiles()->paginate();

        return view('admin.pages.plans.profiles.profiles', compact('plan', 'profiles'));
    }

    public function plans($idprofile)
    {
        $profile = $this->profile->find($idprofile);

        if (!$idprofile) {
            return redirect()->back();
        }

        $plans = $profile->plans()->paginate();

        return view('admin.pages.profiles.plans.plans', compact('plans', 'profile'));
    }

    /**
     * Recupera as permissões não associadas a um perfil para que o perfil adicione somente associação ao qual não está vinculado.
     */
    public function profilesAvailable(Request $request, $idplan)
    {
        if (!$plan = $this->plan->find($idplan)) {
            return redirect()->back();
        }

        $filters = $request->except('_token');

        $profiles = $plan->profilesAvailable($request->filter);

        return view('admin.pages.plans.profiles.available', compact('plan', 'profiles', 'filters'));
    }

    /**
     * Associa uma ou mais planos a um perfil
     */
    public function attachprofilesplan(Request $request, $idplan)
    {
        if (!$plan = $this->plan->find($idplan)) {
            return redirect()->back();
        }

        if (!$request->profiles || count($request->profiles) == 0) {
            return redirect()->back()->with('info', 'Você precisa selecionar um perfil.');
        }

        $plan->profiles()->attach($request->profiles);

        return redirect()->route('plans.profiles', $plan->id);
    }

    /**
     * Desvincula uma permissão de um perfil.
     */
    public function detachPlanProfile($idplan, $idprofile)
    {
        $plan = $this->plan->find($idplan);
        $profile = $this->profile->find($idprofile);

        if (!$plan || !$profile) {
            return redirect()->back();
        }

        $plan->profiles()->detach($profile);

        return redirect()->route('plans.profiles', $plan->id);
    }
}
