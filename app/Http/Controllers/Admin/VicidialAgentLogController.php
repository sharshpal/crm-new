<?php

namespace App\Http\Controllers\Admin;

use App\AdminListingFilter;
use App\Helpers\DatabaseConnection;
use App\Http\Controllers\Controller;
use App\Http\Exports\StatusStatExport;
use App\Http\Exports\TimeStatExport;
use App\Http\Requests\Admin\VicidialAgentLog\BulkDestroyAgentLog;
use App\Http\Requests\Admin\VicidialAgentLog\DestroyAgentLog;
use App\Http\Requests\Admin\VicidialAgentLog\IndexVicidialAgentLog;
use App\Http\Requests\Admin\VicidialAgentLog\StoreAgentLog;
use App\Http\Requests\Admin\VicidialAgentLog\UpdateAgentLog;
use App\Models\VicidialAgentLog;
use App\Models\RecServer;
use Brackets\AdminListing\Facades\AdminListing;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Excel;
use phpDocumentor\Reflection\Types\False_;

class VicidialAgentLogController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexVicidialAgentLog $request
     * @return array|Factory|View
     */
    public function agentLog(IndexVicidialAgentLog $request){


        $dbConnName = $this->setRecServerConnection($request->input("server") ? $request->input("server") : null);

        $computed = $this->getTimeStats($request,$dbConnName);

        $data = $computed["data"];
        $campaigns = $computed["campaigns"];

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return ['data' => $data, "campaigns" => $campaigns];
        }


        return view('admin.vicidial-agent-log.agent-log',
            [
                'data' => $data,
                'recServer' => RecServer::getAllRecServerList(),
                'campaigns' => $campaigns,
                'exportUrl' => route("export-time-stats")
            ]);

    }



    public function agentStatLog(IndexVicidialAgentLog $request)
    {

        $dbConnName = $this->setRecServerConnection($request->input("server") ? $request->input("server") : null);

        $computed = $this->getStatusStats($request,$dbConnName);

        $data = $computed["data"];
        $campaigns = $computed["campaigns"];

        if ($request->ajax()) {
            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }
            return [
                'data' => $data,
                'campaigns' => $campaigns
            ];
        }

        return view('admin.vicidial-agent-log.agent-stat-log',
            [
                'data' =>   json_encode($data,JSON_HEX_APOS),
                'recServer' => RecServer::getAllRecServerList(),
                'campaigns' => $campaigns,
                'exportUrl' => route("export-status-stats")
            ]);

    }


    public function exportTimeStats(IndexVicidialAgentLog $request)
    {

        $dbConnName = $this->setRecServerConnection($request->input("server") ? $request->input("server") : null);

        $computed = $this->getTimeStats($request,$dbConnName,true);

        $data = $computed["data"];
        $campaigns = $computed["campaigns"];

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
        $nameOfExportedFile = str_replace(" ", "_", "export_time_stats_{$filtersString}_at_{$currentTime}.xlsx");

        $columns = ['user_group', 'full_name', 'user', 'pause_hour', 'pause_perc', 'wait_hour', 'wait_perc', 'talk_hour', 'talk_perc', 'after_call_work_hour','after_call_work_perc', 'login_time_hour', 'effective_time_hour'];

        $dataToDownload = new TimeStatExport($data, $columns);

        return \Maatwebsite\Excel\Facades\Excel::download($dataToDownload, $nameOfExportedFile);
    }


    public function exportStatusStats(IndexVicidialAgentLog $request)
    {

        $dbConnName = $this->setRecServerConnection($request->input("server") ? $request->input("server") : null);

        $computed = $this->getStatusStats($request,$dbConnName);

        $data = $computed["data"];
        $campaigns = $computed["campaigns"];

        $realdata = array_map(function($x){
            return (object)$x;
        },array_values($data->data["rows"]));



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
        $nameOfExportedFile = str_replace(" ", "_", "export_status_stats_{$filtersString}_at_{$currentTime}.xlsx");

        $columns = array_merge(['userinfo', 'user','calls'],$data->data["statuses"]);

        $dataToDownload = new StatusStatExport(collect($realdata), $columns);

        return \Maatwebsite\Excel\Facades\Excel::download($dataToDownload, $nameOfExportedFile);
    }


    private function setRecServerConnection($serverId){

        $dbConn = null;
        $dbConnName = null;
        if($serverId){
            $recServer = RecServer::find($serverId);
            if ($recServer) {
                $dbConn = DatabaseConnection::setConnection($recServer->getSelfConnectionName(), $recServer);
                $dbConnName = $recServer->getSelfConnectionName();
            }
        }

        return $dbConnName;
    }


    private function getTimeStats(IndexVicidialAgentLog $request, $dbConnName, $forceBulk = false) : array{

        try {

            $queryColumns = ['agent_log_id', 'user', 'server_ip', 'event_time', 'campaign_id', 'status', 'user_group', 'uniqueid', 'pause_type'];

            //DB::enableQueryLog(); // Enable query log
            // create and AdminListing instance for a specific model and
            $data = AdminListingFilter::create(VicidialAgentLog::class)->processRequestAndGet(
            // pass the request with params
                $request,

                // set columns to query
                $queryColumns,

                // set columns to searchIn
                ['user'],

                function (Builder $query) use ($request,$queryColumns){
                    $query->timeStatQuery($request, $queryColumns);
                    $query->eventTimeFilterQuery($request);
                    return $query;
                },
                null,
                ['campaign_id'],
                $forceBulk,
                $dbConnName
            );
            //dd(DB::getQueryLog()); // Show results of log


            $campaigns = VicidialAgentLog::on($dbConnName)->select("campaign_id","campaign_id as id")
                ->whereNotNull("status")->where("status",'<>','')
                //->eventTimeFilterQuery($request)
                ->distinct()
                ->orderBy("campaign_id",'asc')
                ->groupBy("campaign_id")
                ->get();


            return ['data' => $data, "campaigns" => $campaigns];

        } catch (Exception $e) {

            abort(500, "Errore durante il collegamento al server delle registrazioni");
        }
    }

    private function getStatusStats(IndexVicidialAgentLog $request, $dbConnName) : array{

        try {

            $statuses = [];
            $users = [];
            $res = [];

            $queryColumns = ['agent_log_id', 'user', 'server_ip', 'event_time', 'campaign_id', 'status', 'user_group', 'uniqueid', 'pause_type'];

            // create and AdminListing instance for a specific model and
            $data = AdminListingFilter::create(VicidialAgentLog::class)->processRequestAndGet(
            // pass the request with params
                $request,

                // set columns to query
                $queryColumns,

                // set columns to searchIn
                ['user'],

                function (Builder $query) use ($request,$queryColumns){
                    $query->whereNotNull("status")->where("status",'<>','');
                    $query->statusStatQuery($request, $queryColumns);
                    $query->eventTimeFilterQuery($request);
                    return $query;
                },
                null,
                ['campaign_id'],
                true,
                $dbConnName
            );

            $object = new \stdClass();
            $object->data = ["rows"=>[],"statuses"=>[]];
            $object->current_page = 1;
            $object->from = null;
            $object->last_page = 1;
            $object->to = null;
            $object->total = 0;
            $object->links = [];
            $object->path = null;
            $object->per_page = 100;
            $object->next_page_url = null;
            $object->prev_page_url = null;
            $object->first_page_url = null;
            $object->last_page_url = null;

            $campaigns = [];

            if(count($data->toArray())>0){

                $statuses = VicidialAgentLog::on($dbConnName)->select("status")
                    ->whereNotNull("status")->where("status",'<>','')
                    //->eventTimeFilterQuery($request)
                    ->distinct()
                    ->orderBy("status",'asc')
                    ->groupBy("status")
                    ->get()->pluck("status")->toArray();


                /*
                $statuses = AdminListingFilter::create(VicidialAgentLog::class)->processRequestAndGet(
                // pass the request with params
                    $request,

                    // set columns to query
                    $queryColumns,

                    // set columns to searchIn
                    ['user'],

                    function (Builder $query) use ($request,$queryColumns){
                        $query->select("status")
                            ->whereNotNull("status")->where("status",'<>','')
                            ->eventTimeFilterQuery($request)
                            ->distinct()
                            ->orderBy("status",'asc')
                            ->groupBy("status");

                        return $query;
                    },
                    null,
                    ['campaign_id'],
                    true,
                    $dbConnName
                )->pluck("status")->toArray();
                */

                /*
                $users = VicidialAgentLog::on($dbConnName)->select("user")
                    ->whereNotNull("status")->where("status",'<>','')
                    ->eventTimeFilterQuery($request)
                    ->with(['user' => function ($query) {
                         $query->select('user', 'full_name', 'user_group');
                     }])
                    ->distinct()
                    ->orderBy("user",'asc')
                    ->groupBy("user")
                    ->get();
                */

                $users = AdminListingFilter::create(VicidialAgentLog::class)->processRequestAndGet(
                // pass the request with params
                    $request,

                    // set columns to query
                    $queryColumns,

                    // set columns to searchIn
                    ['user'],

                    function (Builder $query) use ($request,$queryColumns){
                        $query->select("user")
                            ->whereNotNull("status")->where("status",'<>','')
                            ->eventTimeFilterQuery($request)
                            ->with(['user' => function ($query) {
                                $query->select('user', 'full_name', 'user_group');
                            }])
                            ->distinct()
                            ->orderBy("user",'asc')
                            ->groupBy("user");

                        return $query;
                    },
                    null,
                    ['campaign_id'],
                    true,
                    $dbConnName
                );

                $campaigns = VicidialAgentLog::on($dbConnName)->select("campaign_id","campaign_id as id")
                    ->whereNotNull("status")->where("status",'<>','')
                    //->eventTimeFilterQuery($request)
                    ->distinct()
                    ->orderBy("campaign_id",'asc')
                    ->groupBy("campaign_id")
                    ->get();

                foreach($users as $u){
                    $res[$u->user] = [
                        "user" => $u->user,
                        "userinfo" => $u->user()->select("user","full_name","user_group")->first()->toArray(),
                        "statuses"=>array_fill_keys($statuses,0),
                        "calls" => 0
                    ];
                }

                foreach($data as $row){
                    if(isset($res[$row->user])){
                        $res[$row->user]["statuses"][$row->status] = $row->calls;
                        $res[$row->user]["calls"] += $row->calls;
                    }
                }

                uasort($res,function($a,$b){
                    if ($a['userinfo']['full_name'] == $b['userinfo']['full_name']) {
                        return 0;
                    }
                    return ($a['userinfo']['full_name'] > $b['userinfo']['full_name']) ? +1 : -1;
                });

                $object->data = ["rows"=>$res,"statuses"=>$statuses];
            }


            return [
                'data' => $object,
                'campaigns' => $campaigns
            ];


        } catch (Exception $e) {

            abort(500, "Errore durante il collegamento al server delle registrazioni");
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('admin.vicidial-agent-log.create');

        return view('admin.vicidial-agent-log.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreAgentLog $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreAgentLog $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the AgentLog
        $agentLog = VicidialAgentLog::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/vicidial-agent-log'), 'message' => trans('vicidial-agent-logadmin.operation.succeeded')];
        }

        return redirect('admin/vicidial-agent-log');
    }

    /**
     * Display the specified resource.
     *
     * @param VicidialAgentLog $agentLog
     * @return void
     * @throws AuthorizationException
     */
    public function show(VicidialAgentLog $agentLog)
    {
        $this->authorize('admin.vicidial-agent-log.show', $agentLog);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param VicidialAgentLog $agentLog
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function edit(VicidialAgentLog $agentLog)
    {
        $this->authorize('admin.vicidial-agent-log.edit', $agentLog);


        return view('admin.vicidial-agent-log.edit', [
            'agentLog' => $agentLog,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateAgentLog $request
     * @param VicidialAgentLog $agentLog
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateAgentLog $request, VicidialAgentLog $agentLog)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values AgentLog
        $agentLog->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/vicidial-agent-log'),
                'message' => trans('vicidial-agent-logadmin.operation.succeeded'),
            ];
        }

        return redirect('admin/vicidial-agent-log');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyAgentLog $request
     * @param VicidialAgentLog $agentLog
     * @return ResponseFactory|RedirectResponse|Response
     * @throws Exception
     */
    public function destroy(DestroyAgentLog $request, VicidialAgentLog $agentLog)
    {
        $agentLog->delete();

        if ($request->ajax()) {
            return response(['message' => trans('vicidial-agent-logadmin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyAgentLog $request
     * @return Response|bool
     * @throws Exception
     */
    public function bulkDestroy(BulkDestroyAgentLog $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    VicidialAgentLog::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('vicidial-agent-logadmin.operation.succeeded')]);
    }
}
