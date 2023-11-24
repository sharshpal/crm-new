<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SysSetting\BulkDestroySysSetting;
use App\Http\Requests\Admin\SysSetting\DestroySysSetting;
use App\Http\Requests\Admin\SysSetting\IndexSysSetting;
use App\Http\Requests\Admin\SysSetting\StoreSysSetting;
use App\Http\Requests\Admin\SysSetting\UpdateSysSetting;
use App\Models\SysSetting;
use Brackets\AdminListing\Facades\AdminListing;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class SysSettingsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexSysSetting $request
     * @return array|Factory|View
     */
    public function index(IndexSysSetting $request)
    {
        // create and AdminListing instance for a specific model and
        $data = AdminListing::create(SysSetting::class)->processRequestAndGet(
            // pass the request with params
            $request,

            // set columns to query
            ['id', 'crm_user', 'key'],

            // set columns to searchIn
            ['id', 'key', 'value'],

            function ($query) use ($request) {
                $query->with(["crm_user"]);
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

        return view('admin.sys-setting.index', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.sys-setting.create');

        $colors = Config::get('sys-settings.color.values');

        $colorNames = Config::get('sys-settings.color.names');

        $value = [
            'colors' => $colors,
            'templateSettings' => []
        ];

        $data = [
            "crm_user" => null,
            "key"=> "template",
            "value" => $value
        ];

        return view('admin.sys-setting.create',[
            'availableKeys' => [["id"=>"global","name"=>"GLOBAL"],["id"=>"template","name"=>"TEMPLATE"]],
            'data' => $data,
            'colorNames' => $colorNames
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreSysSetting $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreSysSetting $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the SysSetting
        $sysSetting = SysSetting::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/sys-settings'), 'message' => trans('admin.operation.succeeded')];
        }

        return redirect('admin/sys-settings');
    }

    /**
     * Display the specified resource.
     *
     * @param SysSetting $sysSetting
     * @throws AuthorizationException
     * @return void
     */
    public function show(SysSetting $sysSetting)
    {
        $this->authorize('admin.sys-setting.show', $sysSetting);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param SysSetting $sysSetting
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(SysSetting $sysSetting)
    {
        $this->authorize('admin.sys-setting.edit', $sysSetting);

        $colorNames = Config::get('sys-settings.color.names');

        $sysSetting->key = ["id"=>$sysSetting->key,"name"=>ucfirst($sysSetting->key)];

        return view('admin.sys-setting.edit', [
            'availableKeys' => [["id"=>"global","name"=>"GLOBAL"],["id"=>"template","name"=>"TEMPLATE"]],
            'sysSetting' => $sysSetting,
            'colorNames' => $colorNames
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSysSetting $request
     * @param SysSetting $sysSetting
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateSysSetting $request, SysSetting $sysSetting)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values SysSetting
        $sysSetting->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/sys-settings'),
                'message' => trans('admin.operation.succeeded'),
            ];
        }

        return redirect('admin/sys-settings');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroySysSetting $request
     * @param SysSetting $sysSetting
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroySysSetting $request, SysSetting $sysSetting)
    {
        $sysSetting->delete();

        if ($request->ajax()) {
            return response(['message' => trans('admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroySysSetting $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroySysSetting $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    SysSetting::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('admin.operation.succeeded')]);
    }


    public function editSysTemplate(){
        return redirect()->action('App\Http\Controllers\Admin\SysSettingsController@edit',["sysSetting"=>10]);
    }

}
