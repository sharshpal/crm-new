<?php

namespace App\Http\Requests\DatiContratto;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreDatiContratto extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        if(Auth::user()->hasRole("Admin")) return true;

        $isValid = Gate::allows('dati-contratto.create');
        $sanitized = $this->getSanitized();

        $aC = Auth::user()->hasAssignedCampaigns();
        $aP = Auth::user()->hasAssignedPartners();

        if(($aC || (!$aC && !$aP)) && isset($sanitized["campagna"])){
            $isValid &= Auth::user()->hasCampaign($sanitized["campagna"]);
        }
        if(($aP || (!$aC && !$aP)) && isset($sanitized["partner"])){
            $isValid &= Auth::user()->hasPartner($sanitized["partner"]);
        }

        return $isValid;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'campagna' => ['required', 'array'],
            'crm_user' => ['nullable', 'array'],
            'partner' => ['nullable', 'array'],
            'codice_pratica' => ['nullable', 'string'],
            'tipo_inserimento' => ['required', 'array'],
            'tipo_contratto' => ['required', 'array'],
            'tipo_offerta' => ['required', 'array'],
            'owner_nome' => ['required', 'string'],
            'owner_cognome' => ['required', 'string'],
            'owner_dob' => ['required', 'string'],
            'owner_pob' => ['required', 'string'],
            'owner_cf' => ['nullable', 'string'],
            'owner_tipo_doc' => ['required', 'array'],
            'owner_nr_doc' => ['required', 'string'],
            'owner_ente_doc' => ['required', 'string'],
            'owner_doc_data' => ['required', 'string'],
            'owner_doc_scadenza' => ['required', 'string'],
            'owner_piva' => ['nullable', 'string'],
            'owner_rag_soc' => ['nullable', 'string'],
            'owner_email' => ['nullable','string'],
            'telefono' => ['required', 'string'],
            'cellulare' => ['nullable', 'string'],
            'owner_indirizzo' => ['required', 'string'],
            'owner_civico' => ['required', 'string'],
            'owner_comune' => ['required', 'string'],
            'owner_prov' => ['required', 'string'],
            'owner_cap' => ['required', 'string'],
            'owner_az_nome_societa' => ['nullable', 'string'],
            'owner_az_codice_business' => ['nullable', 'string'],
            'owner_az_comune' => ['nullable', 'string'],
            'owner_az_prov' => ['nullable', 'string'],
            'owner_az_cap' => ['nullable', 'string'],
            'forn_indirizzo' => ['required', 'string'],
            'forn_civico' => ['required', 'string'],
            'forn_comune' => ['required', 'string'],
            'forn_prov' => ['required', 'string'],
            'forn_cap' => ['required', 'string'],
            'fatt_indirizzo' => ['required', 'string'],
            'fatt_civico' => ['required', 'string'],
            'fatt_comune' => ['required', 'string'],
            'fatt_prov' => ['required', 'string'],
            'fatt_cap' => ['required', 'string'],
            'mod_pagamento' => ['required', 'array'],
            'sdd_iban' => ['nullable', 'string'],
            'sdd_ente' => ['nullable', 'string'],
            'sdd_intestatario' => ['nullable', 'string'],
            'sdd_cf' => ['nullable', 'string'],
            'delega' => ['required', 'array'],
            'delega_nome' => ['nullable', 'string'],
            'delega_cognome' => ['nullable', 'string'],
            'delega_dob' => ['nullable', 'string'],
            'delega_pob' => ['nullable', 'string'],
            'delega_cf' => ['nullable', 'string'],
            'delega_tipo_doc' => ['nullable', 'array'],
            'delega_nr_doc' => ['nullable', 'string'],
            'delega_ente_doc' => ['nullable', 'string'],
            'delega_doc_data' => ['nullable', 'string'],
            'delega_doc_scadenza' => ['nullable', 'string'],
            'delega_tipo_rapporto' => ['nullable', 'string'],
            'titolarita_immobile' => ['nullable', 'array'],
            'luce_polizza' => ['nullable', 'boolean'],
            'luce_pod' => ['nullable', 'string'],
            'luce_kw' => ['nullable', 'string'],
            'luce_tensione' => ['nullable', 'string'],
            'luce_consumo' => ['nullable', 'string'],
            'luce_fornitore' => ['nullable', 'string'],
            'luce_mercato' => ['nullable', 'string'],
            'gas_polizza' => ['nullable', 'boolean'],
            'gas_polizza_caldaia' => ['nullable', 'boolean'],
            'gas_pdr' => ['nullable', 'string'],
            'gas_consumo' => ['nullable', 'string'],
            'gas_fornitore' => ['nullable', 'string'],
            'gas_matricola' => ['nullable', 'string'],
            'gas_remi' => ['nullable', 'string'],
            'gas_mercato' => ['nullable', 'string'],
            'tel_offerta' => ['nullable', 'string'],
            'tel_cod_mig_voce' => ['nullable', 'string'],
            'tel_cod_mig_adsl' => ['nullable', 'string'],
            'tel_fornitore' => ['nullable', 'string'],
            'tel_tipo_linea' => ['nullable', 'array'],
            'tel_iccd' => ['nullable', 'string'],
            'tel_scadenza_telecom' => ['nullable', 'string'],
            'note_ope' => ['nullable', 'string'],
            'note_bo' => ['nullable', 'string'],
            'note_sv' => ['nullable', 'string'],
            'esito' => ['nullable', 'array'],
            'id_rec' => ['nullable', 'integer'],
            'tipo_fatturazione' => ['required','array'],
            'tipo_fatturazione_email' => ['nullable','string'],
            'tipo_fatturazione_cartaceo' => ['nullable','string'],
            'fascia_reperibilita' => ['required','array'],
            'recall_at' => ['nullable','string'],
            'recover_at' => ['nullable','string'],
            'created_at' => ['nullable','string'],
            'lista' => ['nullable','string'],
            'tel_tipo_passaggio' => ['required_if:tipo_offerta.id,=,telefonia','array'],
            'tel_cellulare_assoc' => ['required_if:tel_tipo_passaggio.id,=,mnp','nullable','string'],
            'tel_finanziamento' => ['nullable','array'],
            'tel_canone' => ['nullable','string'],
            'tel_sell_smartphone' => ['nullable','array'],
            'tel_gia_cliente' => ['nullable','array'],
        ];
    }

    /**
     * Modify input data
     *
     * @return array
     */
    public function getSanitized(): array
    {

        $sanitized = $this->validate($this->rules());

        if(isset($sanitized["errors"])){
           return [];
        }

        if (!empty($sanitized["crm_user"]["id"])) {
            $sanitized["crm_user"] = $sanitized["crm_user"]["id"];
        }
        else{
            $sanitized["crm_user"] = Auth::user()->id;
        }

        if (!empty($sanitized["campagna"]["id"])) {
            $sanitized["campagna"] = $sanitized["campagna"]["id"];
        }
        if (!empty($sanitized["partner"]["id"])) {
            $sanitized["partner"] = $sanitized["partner"]["id"];
        }
        if (!empty($sanitized["esito"]["id"])) {
            $sanitized["esito"] = $sanitized["esito"]["id"];
        }
        if (!empty($sanitized["mod_pagamento"]["id"])) {
            $sanitized["mod_pagamento"] = $sanitized["mod_pagamento"]["id"];
        }
        if (!empty($sanitized["tipo_contratto"]["id"])) {
            $sanitized["tipo_contratto"] = $sanitized["tipo_contratto"]["id"];
        }
        if (!empty($sanitized["tipo_inserimento"]["id"])) {
            $sanitized["tipo_inserimento"] = $sanitized["tipo_inserimento"]["id"];
        }
        if (!empty($sanitized["tipo_offerta"]["id"])) {
            $sanitized["tipo_offerta"] = $sanitized["tipo_offerta"]["id"];
        }
        if (!empty($sanitized["titolarita_immobile"]["id"]) && $sanitized["titolarita_immobile"]["id"]!= null) {
            $sanitized["titolarita_immobile"] = $sanitized["titolarita_immobile"]["id"];
        }
        if (!empty($sanitized["tipo_fatturazione"]["id"])) {
            $sanitized["tipo_fatturazione"] = $sanitized["tipo_fatturazione"]["id"];
        }
        if (!empty($sanitized["fascia_reperibilita"]["id"])) {
            $sanitized["fascia_reperibilita"] = $sanitized["fascia_reperibilita"]["id"];
        }
        if (!empty($sanitized["owner_tipo_doc"]["id"])) {
            $sanitized["owner_tipo_doc"] = $sanitized["owner_tipo_doc"]["id"];
        }
        if (!empty($sanitized["delega_tipo_doc"]["id"]) && $sanitized["delega_tipo_doc"]["id"]!= null) {
            $sanitized["delega_tipo_doc"] = $sanitized["delega_tipo_doc"]["id"];
        }

        if (!empty($sanitized["tel_tipo_passaggio"]["id"])) {
            $sanitized["tel_tipo_passaggio"] = $sanitized["tel_tipo_passaggio"]["id"];
        }

        if (!empty($sanitized["tel_tipo_linea"]["id"])) {
            $sanitized["tel_tipo_linea"] = $sanitized["tel_tipo_linea"]["id"];
        }

        $d = isset($sanitized["delega"]["id"]) ? boolval($sanitized["delega"]["id"]) : null;
        if ($d !== null) {
            $sanitized["delega"] = $d;
        }

        $d = isset($sanitized["tel_finanziamento"]["id"]) ? boolval($sanitized["tel_finanziamento"]["id"]) : null;
        if ($d !== null) {
            $sanitized["tel_finanziamento"] = $d;
        }

        $d = isset($sanitized["tel_sell_smartphone"]["id"]) ? boolval($sanitized["tel_sell_smartphone"]["id"]) : null;
        if ($d !== null) {
            $sanitized["tel_sell_smartphone"] = $d;
        }

        $d = isset($sanitized["tel_gia_cliente"]["id"]) ? boolval($sanitized["tel_gia_cliente"]["id"]) : null;
        if ($d !== null) {
            $sanitized["tel_gia_cliente"] = $d;
        }

        if(Auth::user()->hasPermissionTo("dati-contratto.edit-create-date")){
            if(empty($sanitized["created_at"])){
                unset($sanitized["created_at"]);
            }
        }
        else{
            if(array_key_exists("created_at", $sanitized)){
                unset($sanitized["created_at"]);
            }
        }

        if(array_key_exists("updated_at", $sanitized)){
            unset($sanitized["updated_at"]);
        }

        //Add your code for manipulation with request data here

        return $sanitized;
    }
}
