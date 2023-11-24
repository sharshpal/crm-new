<?php

namespace App\Http\Requests\DatiContratto;

use App\Http\Requests\CrmRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class IndexDatiContratto extends CrmRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        if(Auth::user()->hasRole("Admin")) return true;

        $isValid = Gate::allows('dati-contratto.index') || Gate::allows('dati-contratto.personal-ko');

        if(!$this->isAdminRequest()){

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
            'orderBy' => 'in:id,esito,recall_at,campagna,crm_user,partner,codice_pratica,tipo_offerta,tipo_inserimento,tipo_contratto,owner_nome,owner_cognome,owner_dob,owner_pob,owner_cf,owner_tipo_doc,owner_nr_doc,owner_ente_doc,owner_doc_data,owner_doc_scadenza,owner_piva,owner_rag_soc,telefono,cellulare,owner_indirizzo,owner_civico,owner_comune,owner_prov,owner_cap,forn_indirizzo,forn_civico,forn_comune,forn_prov,forn_cap,fatt_indirizzo,fatt_civico,fatt_comune,fatt_prov,fatt_cap,mod_pagamento,sdd_iban,sdd_ente,sdd_intestatario,sdd_cf,delega,delega_nome,delega_cognome,delega_dob,delega_pob,delega_cf,delega_tipo_doc,delega_nr_doc,delega_ente_doc,delega_doc_data,delega_doc_scadenza,delega_tipo_rapporto,titolarita_immobile,luce_polizza,luce_pod,luce_kw,luce_tensione,luce_consumo,luce_fornitore,luce_mercato,gas_pdr,gas_consumo,gas_fornitore,gas_matricola,gas_remi,gas_mercato,tel_offerta,tel_cod_mig_voce,tel_cod_mig_adsl,tel_cellulare_assoc,tel_fornitore,esito|nullable',
            'orderDirection' => 'in:asc,desc|nullable',
            'search' => 'string|nullable',
            'page' => 'integer|nullable',
            'per_page' => 'integer|nullable',

        ];
    }
}
