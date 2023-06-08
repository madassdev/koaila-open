<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserEmailUpdateRequest;
use App\Http\Requests\UserPasswordUpdateRequest;
use App\Http\Requests\UserPersonalInfoUpdateRequest;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    /**
     * Show the user profile settings page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = Auth::user();
        return view('userAccount', compact('user'));
    }

    /**
     * Updates user profile info like name, company name and email address.
     *
     * @param  \App\Http\Requests\UserPersonalInfoUpdateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function savePersonalInfoSettings(UserPersonalInfoUpdateRequest $request)
    {
        // Set user personal info [name, company_name].
        $user = Auth::user();
        $user->name = $request->name;
        $user->company_name = $request->company_name;
        
        // Set user email to the new email provided.
        if ($request->new_email) {
            $user->email = $request->new_email;
        }

        $user->save();

        return redirect()->back()->with('message', 'Account Information saved successfully!');
    }

    /**
     * Updates user password.
     * 
     *@param  \App\Http\Requests\UserPasswordUpdateRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function savePasswordSettings(UserPasswordUpdateRequest $request)
    {
        // Save user password.
        $user = Auth::user();
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('message', 'Account Information saved successfully!');
    }
}