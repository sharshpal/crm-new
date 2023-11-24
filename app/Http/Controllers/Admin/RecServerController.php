<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\DatabaseConnection;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RecServer\BulkDestroyRecServer;
use App\Http\Requests\Admin\RecServer\DestroyRecServer;
use App\Http\Requests\Admin\RecServer\IndexRecServer;
use App\Http\Requests\Admin\RecServer\StoreRecServer;
use App\Http\Requests\Admin\RecServer\UpdateRecServer;
use App\Models\RecServer;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class RecServerController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexRecServer $request
     * @return array|Factory|View
     */
    public function index(IndexRecServer $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(RecServer::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'name', 'type', 'db_driver', 'db_host', 'db_port', 'db_name', 'db_user', 'db_password', 'db_rewrite_host', 'db_rewrite_search', 'db_rewrite_replace'],

            // set columns to searchIn
            ['id', 'name', 'type', 'db_driver', 'db_host', 'db_port', 'db_name', 'db_user', 'db_password', 'db_rewrite_search', 'db_rewrite_replace']
        );

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.rec-server.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.rec-server.create');

        return view('admin.rec-server.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRecServer $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreRecServer $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the RecServer
        $recServer = RecServer::create($sanitized);
        //DB::disconnect('mysql_external');
        //DatabaseConnection::setConnection($recServer->getSelfConnectionName(), $recServer);

        if ($request->ajax()) {
            return ['redirect' => url('admin/rec-server'), 'message' => trans('admin.operation.succeeded')];
        }

        return redirect('admin/rec-server');
    }

    /**
     * Display the specified resource.
     *
     * @param RecServer $recServer
     * @throws AuthorizationException
     * @return void
     */
    public function show(RecServer $recServer)
    {
        $this->authorize('admin.rec-server.show', $recServer);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param RecServer $recServer
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(RecServer $recServer)
    {
        $this->authorize('admin.rec-server.edit', $recServer);


        return view('admin.rec-server.edit', [
            'recServer' => $recServer,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRecServer $request
     * @param RecServer $recServer
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateRecServer $request, RecServer $recServer)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values RecServer
        $recServer->update($sanitized);

        //DB::disconnect($recServer->getSelfConnectionName());
        //DatabaseConnection::setConnection($recServer->getSelfConnectionName(), $recServer);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/rec-server'),
                'message' => trans('admin.operation.succeeded'),
            ];
        }

        return redirect('admin/rec-server');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyRecServer $request
     * @param RecServer $recServer
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyRecServer $request, RecServer $recServer)
    {
        $recServer->delete();

        if ($request->ajax()) {
            return response(['message' => trans('admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyRecServer $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyRecServer $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    RecServer::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('admin.operation.succeeded')]);
    }
}
