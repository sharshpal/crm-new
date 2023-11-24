<?php

namespace App\Http\Controllers\Admin;

use App\AdminListingFilter;
use App\Http\Controllers\Controller;
use App\Http\Exports\TimeStatExport;
use App\Http\Exports\UserPerformanceExport;
use App\Http\Requests\Admin\UserTimelog\BulkDestroyUserTimelog;
use App\Http\Requests\Admin\UserTimelog\DestroyUserTimelog;
use App\Http\Requests\Admin\UserTimelog\IndexUserPerformance;
use App\Http\Requests\Admin\UserTimelog\IndexUserTimelog;
use App\Http\Requests\Admin\UserTimelog\StoreUserTimelog;
use App\Http\Requests\Admin\UserTimelog\UpdateUserTimelog;
use App\Http\Requests\Admin\VicidialAgentLog\IndexVicidialAgentLog;
use App\Models\CrmUser;
use App\Models\DatiContratto;
use App\Models\UserPerformance;
use App\Models\UserTimelog;
use Carbon\Carbon;
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

class UserTimelogController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexUserTimelog $request
     * @return array|Factory|View
     */
    public function index(IndexUserTimelog $request)
    {

        if (empty($request->input("orderBy"))) {
            $request->merge([
                'orderBy' => 'period',
                'orderDirection' => 'desc'
            ]);
        }

        //DB::enableQueryLog(); // Enable query log
        // create and AdminListing instance for a specific model and
        $data = AdminListingFilter::create(UserTimelog::class)->processRequestAndGet(
        // pass the request with params
            $request,

            // set columns to query
            ['id', 'ore', 'minuti', 'user', 'campagna', 'period'],

            // set columns to searchIn
            ['id'],

            function ($query) use ($request) {
                $query->with("user");
                $query->filterUser($request);
                $query->filterPeriod($request);
                $query->samePartnerOfCurrentUser();
                $query->sameCampaignsOfCurrentUser();
            }
        );

        //dd(DB::getQueryLog()); // Show results of log

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }

        return view('admin.user-timelog.index', ['data' => $data]);
    }


    public function userPerformance(IndexUserPerformance $request)
    {

        $data = AdminListingFilter::create(UserPerformance::class)->processRequestAndGet(
        // pass the request with params
            $request,

            // set columns to query
            ['id'],

            // set columns to searchIn
            ['id'],

            function ($query) use ($request) {
                $query->usersPerformanceStatistics($request);
            }
        );


        $data->values()->each(function ($items) {
            $items->makeHidden(['media','avatar_thumb_url','campaigns','partner.logo_thumb_url']);//add this attribute to all records which has the condition
            //$items->partner->makeHidden(['media','logo_thumb_url']);
        });


        //DB::enableQueryLog();
        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data];
        }
        //dd(DB::getQueryLog());

        //profiler_start('view_render');
        $html = view('admin.user-timelog.user_performance_stat', [
            'data' => $data,
            'exportUrl' => route("export-users-performance"),
            'partnersList' => Auth::user()->getPartnerDropdownValues(),
        ])->render();
        //profiler_finish('view_render');

        return $html;

    }


    public function exportUsersPerformance(IndexUserPerformance $request)
    {

        $data = UserPerformance::usersPerformanceStatistics($request)->get();
        $data->each(function ($items) {
            $items->makeHidden(['media','avatar_thumb_url','campaigns','partner.logo_thumb_url']);//add this attribute to all records which has the condition
            //$items->partner->makeHidden(['media','logo_thumb_url']);
        });

        $filtersString = "";
        if($request->has("campaign_id")){
            foreach($request->input("campaign_id") as $cid){
                $filtersString .= "_".str_replace(" ","_",$cid);
            }
        }
        if($request->has("fromDate")){
            $filtersString .= "_from_". str_replace(" ","_", str_replace("00:00:00"," ",$request->input("fromDate")) );
        }
        if($request->has("toDate")){
            $filtersString .= "_to_" .str_replace(" ","_", str_replace("23:59:59"," ",$request->input("toDate")) );
        }


        $currentTime = Carbon::now()->toDateTimeString();
        $nameOfExportedFile = str_replace(" ", "_", "export_user_performance_{$filtersString}_at_{$currentTime}.xlsx");

        $columns = [
            'partner',
            'id',
            'email',
            'full_name',
            'ore',
            'pezzi_singoli',
            'pezzi_singoli_lordo',
            'pezzi_dual',
            'pezzi_dual_lordo',
            'pezzi_energia',
            'pezzi_energia_lordo',
            'pezzi_fisso',
            'pezzi_fisso_lordo',
            'pezzi_mobile',
            'pezzi_mobile_lordo',
            'pezzi_telefonia',
            'pezzi_telefonia_lordo',
            'pezzi_tot',
            'pezzi_tot_lordo',
            'resa',
            'resa_lordo',
        ];

        $dataToDownload = new UserPerformanceExport($data, $columns);

        return \Maatwebsite\Excel\Facades\Excel::download($dataToDownload, $nameOfExportedFile);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('admin.user-timelog.create');

        return view('admin.user-timelog.create', [
            'searchUserRoute' => route("search-user"),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreUserTimelog $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreUserTimelog $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the UserTimelog
        $userTimelog = UserTimelog::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('user-timelog'), 'message' => trans('admin.operation.succeeded')];
        }

        return redirect('user-timelog');
    }

    /**
     * Display the specified resource.
     *
     * @param UserTimelog $userTimelog
     * @return void
     * @throws AuthorizationException
     */
    public function show(UserTimelog $userTimelog)
    {
        $this->authorize('admin.user-timelog.show', $userTimelog);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param UserTimelog $userTimelog
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function edit(UserTimelog $userTimelog)
    {
        $this->authorize('admin.user-timelog.edit', $userTimelog);


        $userTimelog->load("user");

        return view('admin.user-timelog.edit', [
            'userTimelog' => $userTimelog,
            'searchUserRoute' => route("search-user"),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateUserTimelog $request
     * @param UserTimelog $userTimelog
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateUserTimelog $request, UserTimelog $userTimelog)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values UserTimelog
        $userTimelog->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('user-timelog'),
                'message' => trans('admin.operation.succeeded'),
            ];
        }

        return redirect('user-timelog');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyUserTimelog $request
     * @param UserTimelog $userTimelog
     * @return ResponseFactory|RedirectResponse|Response
     * @throws Exception
     */
    public function destroy(DestroyUserTimelog $request, UserTimelog $userTimelog)
    {
        $userTimelog->delete();

        if ($request->ajax()) {
            return response(['message' => trans('admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyUserTimelog $request
     * @return Response|bool
     * @throws Exception
     */
    public function bulkDestroy(BulkDestroyUserTimelog $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    UserTimelog::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('admin.operation.succeeded')]);
    }
}
