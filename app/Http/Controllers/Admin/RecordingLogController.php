<?php

namespace App\Http\Controllers\Admin;

use App\AdminListingFilter;
use App\Helpers\DatabaseConnection;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\RecordingLog\BulkDestroyRecordingLog;
use App\Http\Requests\Admin\RecordingLog\DestroyRecordingLog;
use App\Http\Requests\Admin\RecordingLog\IndexRecordingLog;
use App\Http\Requests\Admin\RecordingLog\StoreRecordingLog;
use App\Http\Requests\Admin\RecordingLog\UpdateRecordingLog;
use App\Models\RecordingLog;
use App\Models\RecServer;
use Brackets\AdminListing\Facades\AdminListing;
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

class RecordingLogController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexRecordingLog $request
     * @return array|Factory|View
     */
    public function index(IndexRecordingLog $request)
    {

        $dbConn = null;
        $dbConnName = null;
        if($request->input("server")){
            $recServer = RecServer::find($request->input("server"));
            if($recServer){
                $dbConn = DatabaseConnection::setConnection($recServer->getSelfConnectionName(), $recServer);
                $dbConnName = $recServer->getSelfConnectionName();
            }
        }

        try {
            // create and AdminListing instance for a specific model and
            $data = AdminListingFilter::create(RecordingLog::class)->processRequestAndGet(
            // pass the request with params
                $request,

                // set columns to query
                ['recording_id', 'channel', 'server_ip', 'extension', 'start_time', 'start_epoch', 'end_time', 'end_epoch', 'length_in_sec', 'length_in_min', 'filename', 'location', 'lead_id', 'user', 'vicidial_id'],

                // set columns to searchIn
                ['recording_id', 'channel', 'server_ip', 'extension', 'filename', 'location', 'user', 'vicidial_id'],

                null,
                null,
                [],
                false,
                $dbConnName
            );

            if ($request->ajax()) {
                if ($request->has('bulk')) {
                    return [
                        'bulkItems' => $data->pluck('recording_id')
                    ];
                }
                return ['data' => $data];
            }

            return view('admin.recording-log.index', ['data' => $data, 'recServer' => RecServer::all()->map(function ($recServer) {
                return [
                    'id' => $recServer->id,
                    'name' => $recServer->name,
                ];
            })->toArray()]);
        }
        catch(Exception $e){

            abort(500,"Errore durante il collegamento al server delle registrazioni");
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function create()
    {
        $this->authorize('admin.recording-log.create');

        return view('admin.recording-log.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRecordingLog $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreRecordingLog $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Store the RecordingLog
        $recordingLog = RecordingLog::create($sanitized);

        if ($request->ajax()) {
            return ['redirect' => url('admin/recording-logs'), 'message' => trans('brackets/admin-ui::admin.operation.succeeded')];
        }

        return redirect('admin/recording-logs');
    }

    /**
     * Display the specified resource.
     *
     * @param RecordingLog $recordingLog
     * @throws AuthorizationException
     * @return void
     */
    public function show(RecordingLog $recordingLog)
    {
        $this->authorize('admin.recording-log.show', $recordingLog);

        // TODO your code goes here
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param RecordingLog $recordingLog
     * @throws AuthorizationException
     * @return Factory|View
     */
    public function edit(RecordingLog $recordingLog)
    {
        $this->authorize('admin.recording-log.edit', $recordingLog);


        return view('admin.recording-log.edit', [
            'recordingLog' => $recordingLog,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRecordingLog $request
     * @param RecordingLog $recordingLog
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateRecordingLog $request, RecordingLog $recordingLog)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values RecordingLog
        $recordingLog->update($sanitized);

        if ($request->ajax()) {
            return [
                'redirect' => url('admin/recording-logs'),
                'message' => trans('brackets/admin-ui::admin.operation.succeeded'),
            ];
        }

        return redirect('admin/recording-logs');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyRecordingLog $request
     * @param RecordingLog $recordingLog
     * @throws Exception
     * @return ResponseFactory|RedirectResponse|Response
     */
    public function destroy(DestroyRecordingLog $request, RecordingLog $recordingLog)
    {
        $recordingLog->delete();

        if ($request->ajax()) {
            return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyRecordingLog $request
     * @throws Exception
     * @return Response|bool
     */
    public function bulkDestroy(BulkDestroyRecordingLog $request) : Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    RecordingLog::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('brackets/admin-ui::admin.operation.succeeded')]);
    }
}
