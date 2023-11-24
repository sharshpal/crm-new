<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Partner\BulkDestroyPartner;
use App\Http\Requests\Admin\Partner\BulkAssignPartnerCampagna;
use App\Http\Requests\Admin\Partner\DestroyPartner;
use App\Http\Requests\Admin\Partner\IndexPartner;
use App\Http\Requests\Admin\Partner\StorePartner;
use App\Http\Requests\Admin\Partner\UpdatePartner;
use App\Models\Campagna;
use App\Models\Partner;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PartnerController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexPartner $request
     * @return array|Factory|View
     */
    public function index(IndexPartner $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Partner::class)->processRequestAndGet(
        // pass the request with params
            $request,

            // set columns to query
            ['id', 'nome'],

            // set columns to searchIn
            ['id', 'nome'],

            function ($query) use ($request) {

                $query->when(!$request->isAdminRequest() && !Auth::user()->hasRole("Admin"), function ($query) use ($request) {
                    $query->allUserPartner();
                });
            },
        );

        $data = $data->toArray();

        if (!$request->isAdminRequest() && !Auth::user()->hasRole("Admin")) {
            $cmp = Campagna::allUserCampaigns()->get()->pluck("id")->toArray();
            foreach ($data["data"] as $dIndex => $dt) {
                if (!empty($dt["campaigns"])) {
                    $tempCmp = [];
                    foreach ($dt["campaigns"] as $index => $cp) {
                        //var_dump($cp["id"],$cmp,in_array($cp->id,$cmp));
                        if (in_array($cp["id"], $cmp)) {
                            $tempCmp[] = $cp;
                        }
                    }
                    $data["data"][$dIndex]["campaigns"] = $tempCmp;
                }
            }
        }

        if ($request->ajax()) {
            if ($request->has('bulk')) {

                return [
                    //'bulkItems' => $data->pluck('id')
                    'bulkItems' => array_map(function ($partner) {
                        return $partner["id"];
                    }, $data)
                ];
            }
            return ['data' => $data];
        }

        return view('admin.partner.index',
            [
                'data' => json_encode($data),
                'campaignsList' => Auth::user()->getCampagnaDropdownValues(),
                'bulkAssignCampagnaRoute' => route("admin/bulk-assign-partner-campagna")
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('admin.partner.create');


        $partner = new Partner();
        $partner->makeVisible("media");
        return view('admin.partner.create', [
            'partner' => $partner,
            'campaigns' => Campagna::get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePartner $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StorePartner $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Partner
        $partner = Partner::create($sanitized);

        // But we do have a roles, so we need to attach the roles to the adminUser
        $partner->campaigns()->sync(collect($request->input('campaigns'), [])->map->id->toArray());

        if ($request->ajax()) {
            return ['redirect' => url('admin/partners'), 'message' => trans('admin.operation.succeeded')];
        }

        return redirect('admin/partners');
    }

    /**
     * Display the specified resource.
     *
     * @param Partner $partner
     * @return void
     * @throws AuthorizationException
     */
    public function show(Partner $partner)
    {
        $this->authorize('admin.partner.show', $partner);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Partner $partner
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function edit(Partner $partner)
    {
        $this->authorize('admin.partner.edit', $partner);

        $partner->load("campaigns");


        $partner->makeVisible("media");

        return view('admin.partner.edit', [
            'partner' => $partner,
            'campaigns' => Campagna::get()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdatePartner $request
     * @param Partner $partner
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdatePartner $request, Partner $partner)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Partner
        $partner->update($sanitized);

        // But we do have a roles, so we need to attach the roles to the adminUser
        $partner->campaigns()->sync(collect($request->input('campaigns'), [])->map->id->toArray());

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/partners'),
                'message' => trans('admin.operation.succeeded'),
            ];
        }

        return redirect('admin/partners');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyPartner $request
     * @param Partner $partner
     * @return ResponseFactory|RedirectResponse|Response
     * @throws Exception
     */
    public function destroy(DestroyPartner $request, Partner $partner)
    {
        $partner->delete();

        if ($request->ajax()) {
            return response(['message' => trans('admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyPartner $request
     * @return Response|bool
     * @throws Exception
     */
    public function bulkDestroy(BulkDestroyPartner $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Partner::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('admin.operation.succeeded')]);
    }

    public function bulkAssignCampagna(BulkAssignPartnerCampagna $request): Response
    {

        DB::transaction(static function () use ($request) {
            collect($request->input('ids'))
                ->chunk(1000)
                ->each(static function ($bulkChunk) use ($request) {
                    $partners = Partner::whereIn('id', $bulkChunk)->get()->all();
                    foreach($partners as $p) {
                        $p->campaigns()->syncWithoutDetaching([$request->input("campagna")]);
                    }
                });
        });

        return response(['message' => trans('admin.operation.succeeded')]);
    }
}
