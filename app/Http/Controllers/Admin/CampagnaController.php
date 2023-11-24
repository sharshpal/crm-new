<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Campagna\BulkDestroyCampagna;
use App\Http\Requests\Admin\Campagna\DestroyCampagna;
use App\Http\Requests\Admin\Campagna\IndexCampagna;
use App\Http\Requests\Admin\Campagna\StoreCampagna;
use App\Http\Requests\Admin\Campagna\UpdateCampagna;
use App\Models\Campagna;
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

class CampagnaController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexCampagna $request
     * @return array|Factory|View
     */
    public function index(IndexCampagna $request)
    {


        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(Campagna::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'nome','tipo'],

            // set columns to searchIn
            ['id', 'nome'],
            function($query) use ($request) {

                $query->when(!$request->isAdminRequest() && !Auth::user()->hasRole("Admin"), function ($query) use ($request) {
                    $query->allUserCampaigns();
                });

            },
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.campagna.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.campaign.create');

        $campagna = new Campagna();
        $campagna->makeVisible("media");
        return view('admin.campagna.create',[
            'campagna' => $campagna
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCampagna $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreCampagna $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Campagna
        $campagna = Campagna::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/campaign'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/campaign');
    }

    /**
     * Display the specified resource.
     *
     * @param Campagna $campagna
     * @throws AuthorizationException
     * @return void
     */
    public function show(Campagna $campagna)
    {
        $this->authorize('admin.campaign.show', $campagna);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Campagna $campagna
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Campagna $campagna)
    {
        $this->authorize('admin.campaign.edit', $campagna);
        $campagna->tipo = ["id" => $campagna->tipo, "label" => ucfirst($campagna->tipo)];
        $campagna->makeVisible("media");

        return view('admin.campagna.edit', [
            'campagna' => $campagna,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCampagna $request
     * @param Campagna $campagna
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateCampagna $request, Campagna $campagna)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Campagna
        $campagna->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/campaign'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/campaign');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyCampagna $request
     * @param Campagna $campagna
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyCampagna $request, Campagna $campagna)
    {
        $campagna->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyCampagna $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyCampagna $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Campagna::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
