<?php

namespace App\Http\Controllers\Admin;

use App\AdminListingFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AdminUser\BulkAssignUserCampagna;
use App\Http\Requests\Admin\AdminUser\DestroyAdminUser;
use App\Http\Requests\Admin\AdminUser\ImpersonalLoginAdminUser;
use App\Http\Requests\Admin\AdminUser\IndexAdminUser;
use App\Http\Requests\Admin\AdminUser\SearchUser;
use App\Http\Requests\Admin\AdminUser\StoreAdminUser;
use App\Http\Requests\Admin\AdminUser\UpdateAdminUser;
use App\Http\Requests\Admin\Partner\BulkAssignPartnerCampagna;
use App\Models\Campagna;
use App\Models\CrmUser;
use App\Models\Partner;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Brackets\AdminAuth\Activation\Facades\Activation;
use Brackets\AdminAuth\Services\ActivationService;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Config;
use Illuminate\View\View;

class AdminUsersController extends Controller
{

    /**
     * Guard used for admin user
     *
     * @var string
     */
    protected $guard = 'admin';

    /**
     * AdminUsersController constructor.
     *
     * @return void
     */
    public function __construct()
    {
        $this->guard = config('admin-auth.defaults.guard');
    }

    /**
     * Display a listing of the resource.
     *
     * @param IndexAdminUser $request
     * @return Factory|View
     */
    public function index(IndexAdminUser $request)
    {

        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(CrmUser::class)->processRequestAndGet(
        // pass the request with params
            $request,

            // set columns to query
            ['id', 'first_name', 'last_name', 'email', 'activated', 'forbidden', 'language', 'last_login_at'],

            // set columns to searchIn
            ['id', 'first_name', 'last_name', 'email', 'language'],

            function ($query) use ($request) {
                $query->with(["roles", "campaigns", "partners"]);
            },
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {

                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }

            return ['data' => $data, 'activation' => Config::get('admin-auth.activation_enabled')];
        }

        return view('admin.admin-user.index', [
            'data' => $data,
            'activation' => Config::get('admin-auth.activation_enabled'),
            'campaignsList' => Auth::user()->getCampagnaDropdownValues(),
            'bulkAssignCampagnaRoute' => route("admin/bulk-assign-user-campagna")
        ]);
    }


    /**
     * Display a listing of the resource.
     *
     * @param IndexAdminUser $request
     * @return Factory|View
     */
    public function searchUser(SearchUser $request)
    {

        // create and AdminListing instance for a specific model and
        $data = AdminListingFilter::create(CrmUser::class)->processRequestAndGet(
        // pass the request with params
            $request,

            // set columns to query
            ['id', 'first_name', 'last_name'],

            // set columns to searchIn
            ['first_name', 'last_name', 'email'],

            function ($query) use ($request) {
                //$query->with(["roles", "campaigns", "partners"]);
                $query->where("activated", 1);
                $query->when(!Auth::user()->hasRole("Admin"), function($query){
                    $query->samePartnerOfCurrentUser();
                    $query->sameCampaignsOfCurrentUser();
                });
                if($request->has("partner") && $request->has("campagna")){
                    $query->hasPartnerAndCampaign($request->input("partner"),$request->input("campagna"));
                }
            },
            null,
            [],
            true
        );

        if (!$request->ajax()) {
            //return $data;
            return;
        }
        foreach($data as $d){
            $d->makeHidden(["resource_url","avatar_thumb_url","first_name","last_name"]);
        }

        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('admin.admin-user.create');

        return view('admin.admin-user.create', [
            'activation' => Config::get('admin-auth.activation_enabled'),
            'roles' => Role::where('guard_name', $this->guard)->get(),
            'partners' => Partner::get(),
            'campaigns' => Campagna::get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAdminUser $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreAdminUser $request)
    {


        $sanitized = $request->getModifiedData();

        $roles = [];
        if (!empty($request->input("roles"))) {
            $roles = $request->input("roles");

            //vue multiselect configured in single-mode
            if (array_key_exists("id", $request->input("roles"))) {
                $roles = [$request->input("roles")];
            }
        }

        $partners = [];
        if (!empty($request->input("partners"))) {
            $partners = $request->input("partners");

            //vue multiselect configured in single-mode
            if (array_key_exists("id", $request->input("partners"))) {
                $partners = [$request->input("partners")];
            }
        }

        $campaigns = [];
        if (!empty($request->input("campaigns"))) {
            $campaigns = $request->input("campaigns");

            //vue multiselect configured in single-mode
            if (array_key_exists("id", $request->input("campaigns"))) {
                $campaigns = [$request->input("campaigns")];
            }
        }

        $adminUser = CrmUser::create($sanitized);

        // But we do have a roles, so we need to attach the roles to the adminUser
        $adminUser->roles()->sync(collect($roles, [])->map->id->toArray());
        $adminUser->partners()->sync(collect($partners, [])->map->id->toArray());
        $adminUser->campaigns()->sync(collect($campaigns, [])->map->id->toArray());

        if ($request->ajax()) {
            return ['redirect' => url('admin/users'), 'message' => trans('admin.operation.succeeded')];
        }

        return redirect('admin/users');
    }

    /**
     * Display the specified resource.
     *
     * @param CrmUser $adminUser
     * @return void
     * @throws AuthorizationException
     */
    public function show(CrmUser $adminUser)
    {
        $this->authorize('admin.admin-user.show', $adminUser);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param CrmUser $adminUser
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function edit(CrmUser $adminUser)
    {
        $this->authorize('admin.admin-user.edit', $adminUser);

        $adminUser->load('roles');
        $adminUser->load('campaigns');
        $adminUser->load('partners');

        $adminUser->password = null;

        return view('admin.admin-user.edit', [
            'adminUser' => $adminUser,
            'activation' => Config::get('admin-auth.activation_enabled'),
            'roles' => Role::where('guard_name', $this->guard)->get(),
            'partners' => Partner::get(),
            'campaigns' => Campagna::get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAdminUser $request
     * @param CrmUser $adminUser
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateAdminUser $request, CrmUser $adminUser)
    {
        // Sanitize input
        $sanitized = $request->getModifiedData();

        // Update changed values CrmUser
        $adminUser->update($sanitized);

        $roles = [];
        if (!empty($request->input("roles"))) {
            $roles = $request->input("roles");

            //vue multiselect configured in single-mode
            if (array_key_exists("id", $request->input("roles"))) {
                $roles = [$request->input("roles")];
            }
        }

        $partners = [];
        if (!empty($request->input("partners"))) {
            $partners = $request->input("partners");

            //vue multiselect configured in single-mode
            if (array_key_exists("id", $request->input("partners"))) {
                $partners = [$request->input("partners")];
            }
        }

        $campaigns = [];
        if (!empty($request->input("campaigns"))) {
            $campaigns = $request->input("campaigns");

            //vue multiselect configured in single-mode
            if (array_key_exists("id", $request->input("campaigns"))) {
                $campaigns = [$request->input("campaigns")];
            }
        }

        // But we do have a roles, so we need to attach the roles to the adminUser
        $adminUser->roles()->sync(collect($roles, [])->map->id->toArray());
        $adminUser->partners()->sync(collect($partners, [])->map->id->toArray());
        $adminUser->campaigns()->sync(collect($campaigns, [])->map->id->toArray());


        if ($request->ajax()) {
            return ['redirect' => url('admin/users'), 'message' => trans('admin.operation.succeeded')];
        }

        return redirect('admin/users');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyAdminUser $request
     * @param CrmUser $adminUser
     * @return ResponseFactory|RedirectResponse|Response
     * @throws Exception
     */
    public function destroy(DestroyAdminUser $request, CrmUser $adminUser)
    {
        $adminUser->delete();

        if ($request->ajax()) {
            return response(['message' => trans('admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Resend activation e-mail
     *
     * @param Request $request
     * @param ActivationService $activationService
     * @param CrmUser $adminUser
     * @return array|RedirectResponse
     */
    public function resendActivationEmail(Request $request, ActivationService $activationService, CrmUser $adminUser)
    {
        if (Config::get('admin-auth.activation_enabled')) {
            $response = $activationService->handle($adminUser);
            if ($response == Activation::ACTIVATION_LINK_SENT) {
                if ($request->ajax()) {
                    return ['message' => trans('admin.operation.succeeded')];
                }

                return redirect()->back();
            } else {
                if ($request->ajax()) {
                    abort(409, trans('admin.operation.failed'));
                }

                return redirect()->back();
            }
        } else {
            if ($request->ajax()) {
                abort(400, trans('admin.operation.not_allowed'));
            }

            return redirect()->back();
        }
    }

    /**
     * @param ImpersonalLoginAdminUser $request
     * @param CrmUser $adminUser
     * @return RedirectResponse
     * @throws  AuthorizationException
     */
    public function impersonalLogin(ImpersonalLoginAdminUser $request, CrmUser $adminUser)
    {
        Auth::login($adminUser);

        if ($request->ajax()) {
            return response(['data' => ["path" => url("dashboard")]]);
        }

        return redirect()->home();
    }


    public function bulkAssignCampagna(BulkAssignUserCampagna $request): Response
    {

        DB::transaction(static function () use ($request) {
            collect($request->input('ids'))
                ->chunk(1000)
                ->each(static function ($bulkChunk) use ($request) {
                    $users = CrmUser::whereIn('id', $bulkChunk)->get()->all();
                    foreach($users as $p) {
                        if(!$p->hasRole("Admin")){
                            $p->campaigns()->syncWithoutDetaching([$request->input("campagna")]);
                        }
                    }
                });
        });

        return response(['message' => trans('admin.operation.succeeded')]);
    }

}
