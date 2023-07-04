<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddOrganizationMemberRequest;
use App\Http\Requests\SaveOrganizationRequest;
use App\Http\Requests\UpdateOrganizationMemberRequest;
use App\Models\Organization;
use App\Models\User;
use App\Notifications\OragnizationMemberInvitedNotification;
use Illuminate\Http\Request;

class OrganizationController extends Controller
{
    /**
     * Show the organization management page.
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = auth()->user();

        if ($user->organization) {
            // User must be an admin.
            $this->authorize('isOrganizationAdmin', $user->organization);
        }
        $organizationMembers = User::whereNotNull('organization_id')->whereOrganizationId($user->organization_id)->get();
        $userOrganization = $user->organization;
        $roles = Organization::$roles;

        return view('organization-settings', ['organization' => $userOrganization, 'members' => $organizationMembers, 'roles' => $roles]);

    }

    /**
     * Assign customer to a member in same organization as authenticated user.
     *
     * @param \App\Http\Requests\SaveOrganizationRequest $request
     * @return \Illuminate\Http\RedirectResponse 
     * 
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException
     * @throws \Illuminate\Auth\Access\AuthorizationException

    */
    public function store(SaveOrganizationRequest $request)
    {
        // Create organization for first time user or update existing user's organization.
        $user = auth()->user();

        if (!$user->organization) {
            // Create and attach user to new organization.
            $organization = Organization::create($request->validated());
            $user->organization_id = $organization->id;
            $user->role = Organization::$adminRole;
            $user->invite_accepted = true;
            $user->save();
        } else {
            // Update organization.
            $organization = $user->organization;

            // User must be an admin.
            $this->authorize('isOrganizationAdmin', $organization);
            $organization->update($request->validated());
        }

        return redirect()->back()->with('message', 'Organization saved successfully.');
    }


    /**
     * Add and invite a new member to the organization.
     *
     * @param \App\Http\Requests\AddOrganizationMemberRequest $request
     * @return \Illuminate\Http\RedirectResponse 
     * 
     * @throws \Illuminate\Auth\Access\AuthorizationException

    */
    public function addMember(AddOrganizationMemberRequest $request)
    {
        $user = auth()->user();

        $this->authorize('isOrganizationAdmin', $user->organization);

        // Create the user with a generated password, and attach to the organization.
        $generatedPassword = str()->random(6);
        $member = User::create([
            'name' => $request->email,
            'email' => $request->email,
            'password' => bcrypt($generatedPassword),
            'organization_id' => $user->organization_id,
            'role' => $request->role,
            'company_name' => $user->company_name,
        ]);

        // Send notification email to invited user, including their generated password.
        $member->notify(new OragnizationMemberInvitedNotification($user, $generatedPassword));

        return back()->with('message', 'Member invited successfully.');
    }

    public function  updateMember(UpdateOrganizationMemberRequest $request)
    {
        $user  = auth()->user();
        $this->authorize('isOrganizationAdmin', $user->organization);

        // Fine member and Update their role
        $member = User::findOrFail($request->member_id);
        $member->role  =  $request->role;
        $member->save();

        return back()->with('message', 'Member updated successfully.');
    }
}