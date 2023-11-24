<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public $adminUser;

    /**
     * Guard used for admin user
     *
     * @var string
     */
    protected $guard = 'admin';

    public function __construct()
    {
        // TODO add authorization
        $this->guard = config('admin-auth.defaults.guard');
    }

    /**
     * Get logged user before each method
     *
     * @param Request $request
     */
    protected function setUser($request)
    {
        if (empty($request->user($this->guard))) {
            abort(404, 'Admin User not found');
        }

        $this->adminUser = $request->user($this->guard);
    }

    /**
     * Show the form for editing logged user profile.
     *
     * @param Request $request
     * @return Factory|View
     */
    public function editProfile(Request $request)
    {
        $this->setUser($request);

        return view('profile.edit-profile', [
            'adminUser' => $this->adminUser,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @throws ValidationException
     * @return array|RedirectResponse|Redirector
     */
    public function updateProfile(Request $request)
    {
        $this->setUser($request);
        $adminUser = $this->adminUser;

        // Validate the request
        $this->validate($request, [
            'first_name' => ['nullable', 'string'],
            'last_name' => ['nullable', 'string'],
            'email' => ['sometimes', 'email', Rule::unique('crm_user', 'email')->ignore($this->adminUser->getKey(), $this->adminUser->getKeyName()), 'string'],
            'language' => ['sometimes', 'string'],

        ]);

        // Sanitize input
        $sanitized = $request->only([
            'first_name',
            'last_name',
            'email',
            'language',

        ]);

        // Update changed values AdminUser
        $this->adminUser->update($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('profile/edit'), 'message' => trans('admin.operation.succeeded')];
        }

        return redirect('profile/edit');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @return Factory|View
     */
    public function editPassword(Request $request)
    {
        $this->setUser($request);

        return view('profile.edit-password', [
            'adminUser' => $this->adminUser,
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @throws ValidationException
     * @return array|RedirectResponse|Redirector
     */
    public function updatePassword(Request $request)
    {
        $this->setUser($request);
        $adminUser = $this->adminUser;

        // Validate the request
        $this->validate($request, [
            'password' => ['sometimes', 'confirmed', 'min:7', 'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9]).*$/', 'string'],

        ]);

        // Sanitize input
        $sanitized = $request->only([
            'password',

        ]);

        //Modify input, set hashed password
        $sanitized['password'] = Hash::make($sanitized['password']);

        // Update changed values AdminUser
        $this->adminUser->update($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('profile/password'), 'message' => trans('admin.operation.succeeded')];
        }

        return redirect('profile/password');
    }
}
