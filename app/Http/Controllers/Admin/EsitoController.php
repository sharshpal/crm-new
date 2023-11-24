<?php

namespace App\Http\Controllers\Admin;

use App\AdminListingFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Esito\BulkDestroyEsito;
use App\Http\Requests\Admin\Esito\DestroyEsito;
use App\Http\Requests\Admin\Esito\IndexEsito;
use App\Http\Requests\Admin\Esito\StoreEsito;
use App\Http\Requests\Admin\Esito\UpdateEsito;
use App\Models\Esito;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class EsitoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexEsito $request
     * @return array|Factory|View
     */
    public function index(IndexEsito $request)
    {

        // create and AdminListing instance for a specific model and
        $data = AdminListingFilter::create(Esito::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'nome', 'cod','is_final','is_new','is_ok','is_recover'],

            // set columns to searchIn
            ['id', 'nome', 'cod']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.esito.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.esito.create');

        return view('admin.esito.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreEsito $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreEsito $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the Esito
        $esito = Esito::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/esito'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/esito');
    }

    /**
     * Display the specified resource.
     *
     * @param Esito $esito
     * @throws AuthorizationException
     * @return void
     */
    public function show(Esito $esito)
    {
        $this->authorize('admin.esito.show', $esito);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Esito $esito
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(Esito $esito)
    {
        $this->authorize('admin.esito.edit', $esito);


        return view('admin.esito.edit', [
            'esito' => $esito,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateEsito $request
     * @param Esito $esito
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateEsito $request, Esito $esito)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values Esito
        $esito->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/esito'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/esito');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyEsito $request
     * @param Esito $esito
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyEsito $request, Esito $esito)
    {
        $esito->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyEsito $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyEsito $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    Esito::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
