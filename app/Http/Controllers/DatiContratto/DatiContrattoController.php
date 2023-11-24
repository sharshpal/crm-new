<?php

namespace App\Http\Controllers\DatiContratto;

use App\Http\Controllers\Controller;
use App\Http\Exports\CheckFatturazioneExport;
use App\Http\Exports\DatiContrattoExport;
use App\Http\Exports\StatisticheEsitiExport;
use App\Http\Requests\DatiContratto\BulkEditoEsitoDatiContratto;
use App\Http\Requests\DatiContratto\ApiCreateDatiContratto;
use App\Http\Requests\DatiContratto\DestroyDatiContratto;
use App\Http\Requests\DatiContratto\EditDatiContratto;
use App\Http\Requests\DatiContratto\EditEsitoContratto;
use App\Http\Requests\DatiContratto\EditNoteContratto;
use App\Http\Requests\DatiContratto\ExportDatiContratto;
use App\Http\Requests\DatiContratto\ExportStatisticheEsiti;
use App\Http\Requests\DatiContratto\ExportVerificaFatturazioneRequest;
use App\Http\Requests\DatiContratto\GetLockedTs;
use App\Http\Requests\DatiContratto\IndexDatiContratto;
use App\Http\Requests\DatiContratto\IndexStatisticheEsiti;
use App\Http\Requests\DatiContratto\RecoverDatiContratto;
use App\Http\Requests\DatiContratto\ShowDatiContratto;
use App\Http\Requests\DatiContratto\StoreDatiContratto;
use App\Http\Requests\DatiContratto\UpdateDatiContratto;
use App\Models\Campagna;
use App\Models\DatiContratto;
use App\Models\Esito;
use App\Models\Partner;
use App\AdminListingFilter;
use App\Models\VicidialUser;
use Carbon\Carbon;
use Exception;
use http\Env\Request;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class DatiContrattoController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param IndexDatiContratto $request
     * @return array|Factory|View
     */
    public function index(IndexDatiContratto $request)
    {

        $selectColumn = ['id', 'campagna', 'partner', 'crm_user', 'update_user', 'codice_pratica', 'tipo_offerta', 'tipo_inserimento', 'tipo_contratto', 'owner_nome', 'owner_cognome', 'owner_dob', 'owner_pob', 'owner_cf', 'owner_tipo_doc', 'owner_nr_doc', 'owner_ente_doc', 'owner_doc_data', 'owner_doc_scadenza', 'owner_piva', 'owner_rag_soc', 'telefono', 'cellulare', 'owner_indirizzo', 'owner_civico', 'owner_comune', 'owner_prov', 'owner_cap', 'forn_indirizzo', 'forn_civico', 'forn_comune', 'forn_prov', 'forn_cap', 'fatt_indirizzo', 'fatt_civico', 'fatt_comune', 'fatt_prov', 'fatt_cap', 'mod_pagamento', 'sdd_iban', 'sdd_ente', 'sdd_intestatario', 'sdd_cf', 'delega', 'delega_nome', 'delega_cognome', 'delega_dob', 'delega_pob', 'delega_cf', 'delega_tipo_doc', 'delega_nr_doc', 'delega_ente_doc', 'delega_doc_data', 'delega_doc_scadenza', 'delega_tipo_rapporto', 'titolarita_immobile', 'luce_polizza', 'luce_pod', 'luce_kw', 'luce_tensione', 'luce_consumo', 'luce_fornitore', 'luce_mercato', 'gas_pdr', 'gas_consumo', 'gas_fornitore', 'gas_matricola', 'gas_remi', 'gas_mercato', 'tel_offerta', 'tel_cod_mig_voce', 'tel_cod_mig_adsl', 'tel_cellulare_assoc', 'tel_fornitore', 'esito', 'created_at', 'recall_at', 'note_ope', 'note_sv', 'note_bo', 'note_verifica'];
        $searchColumn = ['codice_pratica', 'owner_nome', 'owner_cognome', 'owner_cf', 'owner_piva', 'owner_rag_soc', 'luce_pod', 'gas_pdr', 'telefono', 'cellulare', 'note_sv'];
        $dropdownColumns = ['campagna', 'partner', 'esito', 'tipo_contratto', 'tipo_offerta', 'tipo_inserimento', 'crm_user'];

        if (empty($request->input("orderBy"))) {
            $request->merge([
                'orderBy' => 'id',
                'orderDirection' => 'desc'
            ]);
        }

        $concatColumns = [
            ["owner_nome", "owner_cognome"],
            ["owner_cognome", "owner_nome"],
            ["delega_nome", "delega_cognome"],
            ["delega_cognome", "delega_nome"]
        ];

        $esiti = Esito::getEsitiCounters($request, $searchColumn, $concatColumns, false, false, false, true, false);
        $recallCounters = DatiContratto::getRecallCounters($request, $selectColumn, $searchColumn, $dropdownColumns);

        //DB::enableQueryLog(); // Enable query log
        // create and AdminListing instance for a specific model and
        $data = AdminListingFilter::create(DatiContratto::class)->processRequestAndGet(
        // pass the request with params
            $request,

            // set columns to query
            $selectColumn,

            // set columns to searchIn
            $searchColumn,

            function ($query) use ($request) {
                $query->visibleQuery($request);
                $query->createDateFilterQuery($request);
                $query->recallDateFilterQuery($request);

                if (!Auth::user()->hasPermissionTo("dati-contratto.index") && Auth::user()->hasPermissionTo("dati-contratto.personal-ko")) {
                    $query->where("crm_user", Auth::user()->id);
                    $query->whereHas("esito", function ($query) {
                        $query->where("esito.is_final", 1);
                        $query->where("esito.is_ok", 0);
                    });
                }

            },

            null,

            $dropdownColumns
        );

        //dd(DB::getQueryLog()); // Show results of log

        if ($request->ajax()) {

            if ($request->has('bulk')) {
                return [
                    'bulkItems' => $data->pluck('id')
                ];
            }

            return ['data' => $data, 'esiti' => $esiti, 'recallCounters' => $recallCounters];
        }

        $expColsIds = array_merge(["id", 'anno_creazione', 'mese_creazione'], (new DatiContratto())->getFillable());
        $expCols = [];
        foreach ($expColsIds as $idcol) {
            $expCols[] = [
                "id" => $idcol,
                "label" => trans("admin.dati-contratto.export-columns." . $idcol)
            ];
        }

        return view('dati-contratto.index', [
            'data' => $data,
            'campaignsList' => Auth::user()->getCampagnaDropdownValues(),
            'esitiList' => $esiti,
            'selectableEsitiList' => Esito::notNew()->get()->toArray(),
            'partnersList' => Auth::user()->getPartnerDropdownValues(),
            'exportUrl' => 'dati-contratto/export',
            'exportableColumns' => $expCols,
            'recallCounters' => $recallCounters,
            'searchUserRoute' => route("search-user"),
            'bulkEditEsitoRoute' => route("bulk-edit-esito-contratti"),
        ]);
    }

    public function statisticheEsiti(IndexStatisticheEsiti $request)
    {

        $searchColumn = ['codice_pratica', 'owner_nome', 'owner_cognome', 'owner_cf', 'owner_piva', 'luce_pod', 'gas_pdr', 'telefono', 'cellulare', 'note_sv'];

        if (empty($request->input("orderBy"))) {
            $request->merge([
                'orderBy' => 'id',
                'orderDirection' => 'desc'
            ]);
        }

        $concatColumns = [
            ["owner_nome", "owner_cognome"],
            ["owner_cognome", "owner_nome"],
            ["delega_nome", "delega_cognome"],
            ["delega_cognome", "delega_nome"]
        ];

        $groupByPartner = $request->has("groupByPartner") && $request->input("groupByPartner") === "true";
        $groupByCampagna = $request->has("groupByCampagna") && $request->input("groupByCampagna") === "true";
        $groupByUser = $request->has("groupByUser") && $request->input("groupByUser") === "true";
        $groupByLabel = $request->has("groupByLabel") && $request->input("groupByLabel") === "true";

        $esiti = Esito::getEsitiCounters($request, $searchColumn, $concatColumns, $groupByPartner, $groupByCampagna, $groupByUser, $groupByLabel, true);

        $object = new \stdClass();
        $object->data = $esiti;
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

        if ($request->ajax()) {
            return ['data' => $object];
        }

        return view('dati-contratto.statistiche-esiti', [
            'data' => $object,
            'campaignsList' => Auth::user()->getCampagnaDropdownValues(),
            'partnersList' => Auth::user()->getPartnerDropdownValues(),
            'esitiList' => Esito::get(),
            'searchUserRoute' => route("search-user"),
            'exportUrl' => 'export-statistiche-esiti'
        ]);
    }


    /**
     * @param ExportDatiContratto $request
     * @return BinaryFileResponse
     */
    public function exportStatisticheEsiti(ExportStatisticheEsiti $request)
    {

        $currentTime = Carbon::now()->toDateTimeString();
        $nameOfExportedFile = "export_statistiche_esiti_{$currentTime}.xlsx";
        $searchColumn = ['codice_pratica', 'owner_nome', 'owner_cognome', 'owner_cf', 'owner_piva', 'luce_pod', 'gas_pdr', 'telefono', 'cellulare', 'note_sv'];

        if (empty($request->input("orderBy"))) {
            $request->merge([
                'orderBy' => 'id',
                'orderDirection' => 'desc'
            ]);
        }

        $concatColumns = [
            ["owner_nome", "owner_cognome"],
            ["owner_cognome", "owner_nome"],
            ["delega_nome", "delega_cognome"],
            ["delega_cognome", "delega_nome"]
        ];

        $groupByPartner = $request->has("groupByPartner") && $request->input("groupByPartner") === "true";
        $groupByCampagna = $request->has("groupByCampagna") && $request->input("groupByCampagna") === "true";
        $groupByUser = $request->has("groupByUser") && $request->input("groupByUser") === "true";
        $groupByLabel = $request->has("groupByLabel") && $request->input("groupByLabel") === "true";

        $data = Esito::getEsitiCounters($request, $searchColumn, $concatColumns, $groupByPartner, $groupByCampagna, $groupByUser, $groupByLabel, true);

        $columns = ['partner', 'campagna', 'crm_user', 'esito', 'stato', 'partial_total', 'totale_globale', 'partial_total_pz', 'totale_pezzi'];

        return Excel::download(new StatisticheEsitiExport(collect($data["esiti"]), $columns, $data["total"], $data["totalPz"], $groupByPartner, $groupByCampagna, $groupByUser, $groupByLabel), $nameOfExportedFile);
    }


    /**
     * @param ExportDatiContratto $request
     * @return BinaryFileResponse
     */
    public function exportList(ExportDatiContratto $request)
    {

        $currentTime = Carbon::now()->toDateTimeString();
        $nameOfExportedFile = "export_{$currentTime}.xlsx";

        $selectColumn = array_merge(["id"], (new DatiContratto())->getFillable());

        $searchColumn = ['codice_pratica', 'owner_nome', 'owner_cognome', 'owner_cf', 'owner_piva', 'luce_pod', 'gas_pdr', 'telefono', 'cellulare', 'note_sv'];

        // create and AdminListing instance for a specific model and
        $data = AdminListingFilter::create(DatiContratto::class)->processRequestAndGet(
        // pass the request with params
            $request,

            // set columns to query
            $selectColumn,

            // set columns to searchIn
            $searchColumn,

            function ($query) use ($request) {
                $query->visibleQuery($request);
                $query->createDateFilterQuery($request);
                $query->recallDateFilterQuery($request);
            },
            null,

            ['campagna', 'partner', 'esito', 'tipo_contratto', 'tipo_offerta', 'tipo_inserimento', 'crm_user'],

            true
        );

        $columns = $request->input("columns");

        return Excel::download(new DatiContrattoExport($data, $columns), $nameOfExportedFile);
    }


    public function exportVerificaFatturazione(ExportVerificaFatturazioneRequest $request)
    {

        $sanitized = $request->getSanitized();

        $csvData = $sanitized["verifyData"];
        $results = [];

        foreach ($csvData as $rowData) {

            $query = DatiContratto::query();
            $hasFilter = false;

            if (!empty($rowData["cf"])) {
                $query->where("owner_cf", $rowData["cf"]);
                $hasFilter = true;
            }
            if (!empty($rowData["pod"])) {
                $query->where("luce_pod", $rowData["pod"]);
                $hasFilter = true;
            }
            if (!empty($rowData["pdr"])) {
                $query->where("gas_pdr", $rowData["pdr"]);
                $hasFilter = true;
            }
            if (!empty($rowData["cod_pr"])) {
                $query->where("codice_pratica", $rowData["cod_pr"]);
                $hasFilter = true;
            }
            if (!empty($rowData["campagna"])) {
                $query->where("campagna", $rowData["campagna"]);
                $hasFilter = true;
            }


            $dt = $hasFilter ? $query->get()->all() : [];


            $row = ["row" => $rowData["row"] + 1, "ids" => [], "error" => "", "saved" => "NO"];

            $totDT = count($dt);

            if ($totDT > 1) {
                foreach ($dt as $datiContratto) {
                    $row["ids"][] = $datiContratto->id;
                    $row["error"] = "Match con più contratti";
                }
            } elseif ($totDT == 1) {
                $datiContratto = $dt[0];
                $doSave = false;
                $hasError = false;
                if (!empty($rowData["note"])) {
                    $datiContratto->note_verifica .= "\n\n" . $rowData["note"];
                    $doSave = true;
                }
                if (!empty($rowData["stato"])) {
                    if (Esito::where("id", $rowData["stato"])->first()) {
                        $datiContratto->esito = $rowData["stato"];
                        $doSave = true;
                    } else {
                        $row["error"] = "Stato inesistente";
                        $hasError = true;
                    }
                }

                $row["ids"][] = $datiContratto->id;

                if ($doSave && !$hasError) {
                    $datiContratto->save();
                    $row["saved"] = "SI";
                }
            }

            $results[] = $row;
        }

        $currentTime = Carbon::now()->toDateTimeString();
        $nameOfExportedFile = str_replace(" ", "_", "verifica_fatturazione_{$currentTime}.xlsx");

        $columns = ['row', 'ids', "saved", "error"];

        $dataToDownload = new CheckFatturazioneExport($results, $columns);

        return Excel::download($dataToDownload, $nameOfExportedFile);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function create()
    {
        $this->authorize('dati-contratto.create');

        $pl = Auth::user()->getPartnerDropdownValues(false,false)->toArray();
        $cl = Auth::user()->getCampagnaDropdownValues();

        $cList = $cl->pluck("id")->toArray();
        $cl = $cl->toArray();

        foreach ($pl as $ind1 => $p) {
            foreach ($p["campaigns"] as $ind2 => $c) {
                if (!in_array($c["id"], $cList)) {
                    unset($p["campaigns"][$ind2]);
                }
            }

            $p["campaigns"] = array_values($p["campaigns"]);
            $pl[$ind1] = $p;
        }


        if (count($pl) > 0) $cl = [];
        if (count($pl) == 1) $cl = $pl[0]["campaigns"];

        $dt = new DatiContratto();
        $dt->crm_user = Auth::user()->id;
        $dt->load("crm_user");
        $dt->created_at = null;

        return view('dati-contratto.create', [
            "datiContratto" => $dt,
            "campaignsList" => $cl,
            "esitiList" => Esito::notNew()->get()->toArray(),
            'partnersList' => $pl,
            "showCp" => Auth::user()->hasPermissionTo("dati-contratto.show-cp"),
            'searchUserRoute' => route("search-user"),
            'dzClickable' => true,
            'dzShowRemoveLink' => true,
            'fetchRecallUrl' => route("getLockedTs"),
            'isEdit' => true,
            'isNew' => true,
            'isApi' => false,
            'attachRoute' => "dtc-attach-file"
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function apicreate(ApiCreateDatiContratto $request)
    {

        $data = $request->getSanitized();

        //Load default data
        $pl = Auth::user()->getPartnerDropdownValues(false,false)->toArray();
        $cl = Auth::user()->getCampagnaDropdownValues();

        $cList = $cl->pluck("id")->toArray();
        $cl = $cl->toArray();

        foreach ($pl as $ind1 => $p) {
            foreach ($p["campaigns"] as $ind2 => $c) {
                if (!in_array($c["id"], $cList)) {
                    unset($p["campaigns"][$ind2]);
                }
            }

            $p["campaigns"] = array_values($p["campaigns"]);
            $pl[$ind1] = $p;
        }


        $dc = new DatiContratto();
        //$dc->operatore = $data["fullname"];
        $dc->telefono = $data["phone_number"];
        $dc->cellulare = !empty($data["alt_phone"]) ? $data["alt_phone"] : "";


        //override by input data
        $vc_partner = VicidialUser::where("full_name", $data["fullname"])->first();

        if ($vc_partner) {
            $partner = Partner::where(DB::raw('lower(vc_usergroup)'), strtolower($vc_partner->user_group))
                ->orWhere(DB::raw('lower(nome)'), strtolower($vc_partner->user_group))
                ->with("campaigns")->first();

            if ($partner) {
                $pl = [$partner];
            }
        }

        if (count($pl) > 0) $cl = [];
        if (count($pl) == 1) $cl = $pl[0]["campaigns"];

        if (count($cl) == 1) $dc->campagna = $cl[0];

        if (!empty($data["campaign"])) {
            $cmp = Campagna::where(DB::raw('lower(nome)'), strtolower($data["campaign"]))->first();

            if ($cmp) {
                foreach ($cl as $cm) {
                    if ($cm["id"] == $cmp->id) {
                        $dc->campagna = $cmp;
                        break;
                    }
                }
            }
        }

        return view('dati-contratto.create', [
            "datiContratto" => $dc,
            "campaignsList" => $cl,
            "esitiList" => Esito::notNew()->get()->toArray(),
            'partnersList' => $pl,
            'apiCreate' => true,
            "showCp" => Auth::user()->hasPermissionTo("dati-contratto.show-cp")
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreDatiContratto $request
     * @return array|RedirectResponse|Redirector
     */
    public function store(StoreDatiContratto $request)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        $esito = Esito::where("is_new", true)->first();
        $esitoId = $esito ? $esito->id : null;
        $sanitized["esito"] = $esitoId;

        $luceFields = [
            'luce_kw',
            'luce_pod',
            'luce_tensione',
            'luce_consumo',
            'luce_fornitore',
            'luce_mercato',
        ];

        $gasFields = [
            'gas_consumo',
            'gas_pdr',
            'gas_fornitore',
            'gas_matricola',
            'gas_remi',
            'gas_mercato',
        ];

        //Se in input arriva un contratto dual, lo sdoppio in due contratti singoli
        // Store the DatiContratto
        if(env("SPLIT_DUAL_ON_CREATE",false) && $sanitized["tipo_offerta"] == "lucegas"){

            //Pulisci dati per contratto gas
            $sGas = $sanitized;
            foreach($luceFields as $f){
                $sGas[$f] = null;
            }
            $sGas["luce_polizza"] = false;
            $sGas["tipo_offerta"] = "gas";
            $datiContrattoGas = DatiContratto::create($sGas);

            //Pulisci dati per contratto luce
            $sLuce = $sanitized;
            foreach($gasFields as $g){
                $sLuce[$g] = null;
            }
            $sLuce["gas_polizza"] = false;
            $sLuce["gas_polizza_caldaia"] = false;
            $sLuce["tipo_offerta"] = "luce";
            $request->offsetUnset('doc');
            $request->offsetUnset('rec');
            $datiContrattoLuce = DatiContratto::create($sLuce);

            if(env("SPLIT_DUAL_COPY_MEDIA",false)){
                //Copia file media
                foreach($datiContrattoGas->media->all() as $media){
                    $datiContrattoLuce
                        ->addMediaFromDisk("/media/{$media->id}/{$media->file_name}","local")
                        ->withCustomProperties($media->custom_properties)
                        ->preservingOriginal()
                        ->toMediaCollection($media->collection_name);
                }
            }

            $datiContratto = $datiContrattoLuce;
        }
        else{
            $datiContratto = DatiContratto::create($sanitized);
        }

        $redirectUrl = "dashboard";

        if (Auth::user()->can("dati-contratto.show")) $redirectUrl = $datiContratto->resource_url . "/show";
        if (Auth::user()->can("dati-contratto.index")) $redirectUrl = "dati-contratto";

        if ($request->ajax()) {
            return ['redirect' => url($redirectUrl), 'message' => trans('admin.operation.succeeded')];
        }


        return redirect($redirectUrl);
    }

    /**
     * Display the specified resource.
     *
     * @param DatiContratto $datiContratto
     * @return void
     * @throws AuthorizationException
     */
    public function show(ShowDatiContratto $request, DatiContratto $datiContratto)
    {
        //$this->authorize('dati-contratto.show', $datiContratto);


        $datiContratto->load("esito");
        $datiContratto->load("campagna");
        $datiContratto->load("partner");
        $datiContratto->load("crm_user");
        $datiContratto->load("update_user");

        $datiContratto["tipo_inserimento"] = ["id" => $datiContratto["tipo_inserimento"], "label" => ucfirst($datiContratto["tipo_inserimento"])];
        $datiContratto["tipo_contratto"] = ["id" => $datiContratto["tipo_contratto"], "label" => ucfirst($datiContratto["tipo_contratto"])];
        $datiContratto["tipo_offerta"] = ["id" => $datiContratto["tipo_offerta"], "label" => ucfirst($datiContratto["tipo_offerta"] == "lucegas" ? "Luce + Gas" : $datiContratto["tipo_offerta"])];
        $datiContratto["tipo_fatturazione"] = ["id" => $datiContratto["tipo_fatturazione"], "label" => ucfirst($datiContratto["tipo_fatturazione"])];
        $datiContratto["fascia_reperibilita"] = ["id" => $datiContratto["fascia_reperibilita"], "label" => ucfirst($datiContratto["fascia_reperibilita"])];

        $datiContratto["mod_pagamento"] = ["id" => $datiContratto["mod_pagamento"], "label" =>   ucwords(str_replace("_", " ", $datiContratto["mod_pagamento"]))];

        $datiContratto["titolarita_immobile"] = empty($datiContratto["titolarita_immobile"]) ? "" : ["id" => $datiContratto["titolarita_immobile"], "label" => ucfirst($datiContratto["titolarita_immobile"])];
        $datiContratto["owner_tipo_doc"] = ["id" => $datiContratto["owner_tipo_doc"], "label" => ucwords(str_replace("_", " ", $datiContratto["owner_tipo_doc"]))];
        $datiContratto["delega_tipo_doc"] = ["id" => $datiContratto["delega_tipo_doc"], "label" => ucwords(str_replace("_", " ", $datiContratto["delega_tipo_doc"]))];
        $datiContratto["delega"] = ["id" => $datiContratto["delega"], "label" => ucfirst($datiContratto["delega"] ? "Si" : "No")];
        $datiContratto["tel_tipo_passaggio"] = ["id" => $datiContratto["tel_tipo_passaggio"], "label" => ucwords(str_replace("_", " ", $datiContratto["tel_tipo_passaggio"]))];
        $datiContratto["tel_tipo_linea"] = ["id" => $datiContratto["tel_tipo_linea"], "label" => ucwords(str_replace("_", " ", $datiContratto["tel_tipo_linea"]))];
        $datiContratto["tel_finanziamento"] = ["id" => $datiContratto["tel_finanziamento"], "label" => ucfirst($datiContratto["tel_finanziamento"] ? "Si" : "No")];
        $datiContratto["tel_sell_smartphone"] = ["id" => $datiContratto["tel_sell_smartphone"], "label" => ucfirst($datiContratto["tel_sell_smartphone"] ? "Si" : "No")];
        $datiContratto["tel_gia_cliente"] = ["id" => $datiContratto["tel_gia_cliente"], "label" => ucfirst($datiContratto["tel_gia_cliente"] ? "Si" : "No")];



        $pl = $datiContratto->partner ? [$datiContratto->partner()->first()->toArray()] : [];

        $cl = Auth::user()->getCampagnaDropdownValues();

        $cList = $cl->pluck("id")->toArray();
        $cl = $cl->toArray();

        foreach ($pl as $ind1 => $p) {
            foreach ($p["campaigns"] as $ind2 => $c) {
                if (!in_array($c["id"], $cList)) {
                    unset($p["campaigns"][$ind2]);
                }
            }
            $p["campaigns"] = array_values($p["campaigns"]);
            $pl[$ind1] = $p;
        }

        if (count($pl) > 0) $cl = [];
        if (count($pl) == 1) $cl = $pl[0]["campaigns"];


        return view('dati-contratto.show', [
            'datiContratto' => $datiContratto,
            "campaignsList" => $cl,
            "partnersList" => $pl,
            "esitiList" => Esito::notNew()->get()->toArray(),
            "showCp" => Auth::user()->hasPermissionTo("dati-contratto.show-cp"),
            'searchUserRoute' => route("search-user"),
            'dzClickable' => false,
            'dzShowRemoveLink' => false,
            'fetchRecallUrl' => route("getLockedTs"),
            'isEdit' => false,
            'isNew' => false,
            'isApi' => true,
            'attachRoute' => false
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param DatiContratto $datiContratto
     * @return Factory|View
     * @throws AuthorizationException
     */
    public function edit(EditDatiContratto $request, DatiContratto $datiContratto)
    {

        $datiContratto->load("esito");
        $datiContratto->load("campagna");
        $datiContratto->load("partner");
        $datiContratto->load("crm_user");
        $datiContratto->load("update_user");

        $datiContratto["tipo_inserimento"] = ["id" => $datiContratto["tipo_inserimento"], "label" => ucfirst($datiContratto["tipo_inserimento"])];
        $datiContratto["tipo_contratto"] = ["id" => $datiContratto["tipo_contratto"], "label" => ucfirst($datiContratto["tipo_contratto"])];
        $datiContratto["tipo_offerta"] = ["id" => $datiContratto["tipo_offerta"], "label" => ucfirst($datiContratto["tipo_offerta"] == "lucegas" ? "Luce + Gas" : $datiContratto["tipo_offerta"])];
        $datiContratto["tipo_fatturazione"] = ["id" => $datiContratto["tipo_fatturazione"], "label" => ucfirst($datiContratto["tipo_fatturazione"])];
        $datiContratto["fascia_reperibilita"] = ["id" => $datiContratto["fascia_reperibilita"], "label" => ucfirst($datiContratto["fascia_reperibilita"])];
        $datiContratto["mod_pagamento"] = ["id" => $datiContratto["mod_pagamento"], "label" =>   ucwords(str_replace("_", " ", $datiContratto["mod_pagamento"]))];
        $datiContratto["titolarita_immobile"] = empty($datiContratto["titolarita_immobile"]) ? "" : ["id" => $datiContratto["titolarita_immobile"], "label" => ucfirst($datiContratto["titolarita_immobile"])];
        $datiContratto["owner_tipo_doc"] = ["id" => $datiContratto["owner_tipo_doc"], "label" => ucwords(str_replace("_", " ", $datiContratto["owner_tipo_doc"]))];
        $datiContratto["delega_tipo_doc"] = ["id" => $datiContratto["delega_tipo_doc"], "label" => ucwords(str_replace("_", " ", $datiContratto["delega_tipo_doc"]))];
        $datiContratto["delega"] = ["id" => $datiContratto["delega"], "label" => ucfirst($datiContratto["delega"] ? "Si" : "No")];
        $datiContratto["tel_tipo_passaggio"] = ["id" => $datiContratto["tel_tipo_passaggio"], "label" => ucwords(str_replace("_", " ", $datiContratto["tel_tipo_passaggio"]))];
        $datiContratto["tel_tipo_linea"] = ["id" => $datiContratto["tel_tipo_linea"], "label" => ucwords(str_replace("_", " ", $datiContratto["tel_tipo_linea"]))];
        $datiContratto["tel_finanziamento"] = ["id" => $datiContratto["tel_finanziamento"], "label" => ucfirst($datiContratto["tel_finanziamento"] ? "Si" : "No")];
        $datiContratto["tel_sell_smartphone"] = ["id" => $datiContratto["tel_sell_smartphone"], "label" => ucfirst($datiContratto["tel_sell_smartphone"] ? "Si" : "No")];
        $datiContratto["tel_gia_cliente"] = ["id" => $datiContratto["tel_gia_cliente"], "label" => ucfirst($datiContratto["tel_gia_cliente"] ? "Si" : "No")];


        $pl = $datiContratto->partner ? [$datiContratto->partner()->first()->toArray()] : [];

        $cl = Auth::user()->getCampagnaDropdownValues();

        $cList = $cl->pluck("id")->toArray();
        $cl = $cl->toArray();

        foreach ($pl as $ind1 => $p) {
            foreach ($p["campaigns"] as $ind2 => $c) {
                if (!in_array($c["id"], $cList)) {
                    unset($p["campaigns"][$ind2]);
                }
            }
            $p["campaigns"] = array_values($p["campaigns"]);
            $pl[$ind1] = $p;
        }

        if (count($pl) > 0) $cl = [];
        if (count($pl) == 1) $cl = $pl[0]["campaigns"];


        return view('dati-contratto.edit', [
            'datiContratto' => $datiContratto,
            "campaignsList" => $cl,
            "partnersList" => $pl,
            "esitiList" => Esito::notNew()->get()->toArray(),
            "showCp" => Auth::user()->hasPermissionTo("dati-contratto.show-cp"),
            'searchUserRoute' => route("search-user"),
            'dzClickable' => true,
            'dzShowRemoveLink' => true,
            'fetchRecallUrl' => route("getLockedTs"),
            'isEdit' => true,
            'isNew' => false,
            'isApi' => false,
            'attachRoute' => "dte-attach-file"
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDatiContratto $request
     * @param DatiContratto $datiContratto
     * @return array|RedirectResponse|Redirector
     */
    public function update(UpdateDatiContratto $request, DatiContratto $datiContratto)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();


        $luceFields = [
            'luce_kw',
            'luce_pod',
            'luce_tensione',
            'luce_consumo',
            'luce_fornitore',
            'luce_mercato'];

        $gasFields = [
            "id",
            'gas_consumo',
            'gas_pdr',
            'gas_fornitore',
            'gas_matricola',
            'gas_remi',
            'gas_mercato'
        ];

        //Se in input arriva un contratto dual, lo sdoppio in due contratti singoli
        // Update changed values DatiContratto
        if(env("SPLIT_DUAL_ON_UPDATE",false) && $sanitized["tipo_offerta"] == "lucegas"){

            //Salvataggio-Aggiornamento gas
            //rimozione valori relativi a luce
            $sGas = $sanitized;
            foreach($luceFields as $f){
                $sGas[$f] = null;
            }
            $sGas["luce_polizza"] = false;
            $sGas["tipo_offerta"] = "gas";
            $datiContratto->update($sGas);

            $datiContratto = DatiContratto::find($datiContratto->id);

            //Salvataggio Luce
            //rimozione valori relativi a gas
            $sLuce = $sanitized;
            foreach($gasFields as $g){
                $sLuce[$g] = null;
            }
            $sLuce["gas_polizza"] = false;
            $sLuce["gas_polizza_caldaia"] = false;
            $sLuce["tipo_offerta"] = "luce";
            $request->offsetUnset('doc');
            $request->offsetUnset('rec');
            $datiContrattoLuce = DatiContratto::create($sLuce);

            if(env("SPLIT_DUAL_COPY_MEDIA",false)){
                //Copia-Duplica file media da gas a luce
                foreach($datiContratto->media->all() as $media){
                    $datiContrattoLuce
                        ->addMediaFromDisk("/media/{$media->id}/{$media->file_name}","local")
                        ->withCustomProperties($media->custom_properties)
                        ->preservingOriginal()
                        ->toMediaCollection($media->collection_name);
                }
            }
        }
        else{
            $datiContratto->update($sanitized);
        }

        $redirectUrl = "dashboard";
        if (Auth::user()->can("dati-contratto.show")) $redirectUrl = $datiContratto->resource_url . "/show";
        if (Auth::user()->can("dati-contratto.index")) $redirectUrl = "dati-contratto/";

        if ($request->ajax()) {
            return [
                'redirect' => url($redirectUrl),
                'message' => trans('admin.operation.succeeded'),
            ];
        }

        return redirect($redirectUrl);
    }

    public function editEsito(EditEsitoContratto $request, DatiContratto $datiContratto)
    {
        // Sanitize input
        $sanitized = $request->getSanitized();

        // Update changed values DatiContratto
        $datiContratto->update($sanitized);
        $redirectUrl = "dashboard";
        if (Auth::user()->can("dati-contratto.show")) $redirectUrl = $datiContratto->resource_url . "/show";
        if (Auth::user()->can("dati-contratto.index")) $redirectUrl = "dati-contratto/";

        if ($request->ajax()) {
            return [
                'redirect' => url($redirectUrl),
                'message' => trans('admin.operation.succeeded'),
            ];
        }

        return redirect($redirectUrl);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateDatiContratto $request
     * @param DatiContratto $datiContratto
     * @return array|RedirectResponse|Redirector
     */
    public function recoverContratto(RecoverDatiContratto $request, DatiContratto $datiContratto)
    {

        $sanitized = $request->getSanitized();

        $e = Esito::where("is_recover", true)->first();

        // Update changed values DatiContratto
        $datiContratto->update($sanitized);

        $redirectUrl = "dashboard";
        if (Auth::user()->can("dati-contratto.show")) $redirectUrl = $datiContratto->resource_url . "/show";
        if (Auth::user()->can("dati-contratto.index")) $redirectUrl = "dati-contratto/";

        if ($request->ajax()) {
            return [
                'redirect' => url($redirectUrl),
                'message' => trans('admin.operation.succeeded'),
            ];
        }

        return redirect($redirectUrl);
    }



    public function editNoteContratto(EditNoteContratto $request, DatiContratto $datiContratto)
    {

        $sanitized = $request->getSanitized();

         // Update changed values DatiContratto
        $datiContratto->update($sanitized);

        $redirectUrl = "dashboard";
        if (Auth::user()->can("dati-contratto.show")) $redirectUrl = $datiContratto->resource_url . "/show";
        if (Auth::user()->can("dati-contratto.index")) $redirectUrl = "dati-contratto/";

        if ($request->ajax()) {
            return [
                'redirect' => url($redirectUrl),
                'message' => trans('admin.operation.succeeded'),
            ];
        }

        return redirect($redirectUrl);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param DestroyDatiContratto $request
     * @param DatiContratto $datiContratto
     * @return ResponseFactory|RedirectResponse|Response
     * @throws Exception
     */
    public function destroy(DestroyDatiContratto $request, DatiContratto $datiContratto)
    {
        $datiContratto->delete();

        if ($request->ajax()) {
            return response(['message' => trans('admin.operation.succeeded')]);
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resources from storage.
     *
     * @param BulkDestroyDatiContratto $request
     * @return Response|bool
     * @throws Exception
     */
    public function bulkDestroy(BulkDestroyDatiContratto $request): Response
    {
        DB::transaction(static function () use ($request) {
            collect($request->data['ids'])
                ->chunk(1000)
                ->each(static function ($bulkChunk) {
                    DatiContratto::whereIn('id', $bulkChunk)->delete();

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('admin.operation.succeeded')]);
    }


    public function bulkEditEsito(BulkEditoEsitoDatiContratto $request): Response
    {

        DB::transaction(static function () use ($request) {
            collect($request->input('ids'))
                ->chunk(1000)
                ->each(static function ($bulkChunk) use ($request) {
                    DatiContratto::whereIn('id', $bulkChunk)->update(["esito" => $request->input("esito")]);

                    // TODO your code goes here
                });
        });

        return response(['message' => trans('admin.operation.succeeded')]);
    }


    public function getLockedTs(GetLockedTs $request)
    {

        $data = DatiContratto::getLockedTs($request)->get();

        return response(['data'=>$data]);
    }

}
