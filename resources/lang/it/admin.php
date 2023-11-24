<?php

return [


    'page_title_suffix' => 'CRM',

    'auth_global' => [
        'email' => 'La tua e-mail',
        'password' => 'Password',
        'password_confirm' => 'Conferma Password',
    ],

    'login' => [
        'title' => 'Login',
        'sign_in_text' => 'Accedi al tuo account',
        'button' => 'Login',
        'forgot_password' => 'Password dimenticata ?',
    ],

    'password_reset' => [
        'title' => 'Reset Password',
        'note' => 'Reset Password dimenticata',
        'button' => 'Reset password',
    ],

    'forgot_password' => [
        'title' => 'Reset Password',
        'note' => 'Invia link di reset via email',
        'button' => 'Invia Link di Reset',
    ],

    'activation_form' => [
        'title' => 'Attiva account',
        'note' => 'Invia link di reset via email',
        'button' => 'Invia Link di Reset',
    ],

    'activations' => [
        'sent' => 'Ti abbiamo inviato un link di attivazione!',
        'activated' => 'Il tuo account è stato attivato',
        'invalid_request' => 'Richiesta fallita',
        'disabled' => "L'attivazione è disabilitata",
    ],

    'passwords' => [
        'reset' => 'La tua password è stata resettata',
        'sent' => 'Ti abbiamo inviato un link per il reset password!',
        'invalid_password' => 'La password deve essere lunga almeno 8 caratteri, contenere lettere e numeri e combaciare con la password di conferma!',
        'invalid_token' => 'Token invalido',
        'invalid_user' => "Utente non trovato",
    ],



    'admin-user' => [
        'title' => 'Utenti',

        'actions' => [
            'index' => 'Elenco Utenti',
            'create' => 'Nuovo Utente',
            'edit' => 'Modifica :name',
            'edit_profile' => 'Modifica Profile',
            'edit_password' => 'Modifica Password',
            'manage' => 'Gestione Utenti',
        ],

        'columns' => [
            'id' => 'ID',
            'last_login_at' => 'Ultimo Login',
            'first_name' => 'Nome',
            'last_name' => 'Cognome',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Conferma Password',
            'activated' => 'Attivo',
            'forbidden' => 'Bloccato',
            'language' => 'Lingua',

            //Belongs to many relations
            'roles' => 'Tipo di Profilo',
            'campaigns' => 'Campagne Assegnate',
            'partners' => 'Partner Assegnati',
            'ipfilter' => 'Ip Consentiti',
        ],
    ],

    'partner' => [
        'title' => 'Partner',
        'assigned' => 'Partner Assegnati',
        'actions' => [
            'index' => 'Elenco Partner',
            'create' => 'Nuovo Partner',
            'edit' => 'Modifca :name',
            'manage' => 'Gestione Partner',
        ],

        'columns' => [
            'id' => 'ID',
            'nome' => 'Nome',
            'campaigns' => 'Campagne Assegnate',
            'vc_usergroup' => 'Vicidial UserGroup',

            //Belongs to many relations
            'campagne' => 'Campagne Assegnate',

        ],
    ],

    'campagna' => [
        'title' => 'Campagne',
        'assigned' => 'Campagne Assegnate',
        'actions' => [
            'index' => 'Elenco Campagne',
            'create' => 'Nuova Campagna',
            'edit' => 'Modifica :name',
            'manage' => 'Gestione Campagne',
        ],

        'columns' => [
            'id' => 'ID',
            'nome' => 'Nome',
            'tipo' => 'Tipo'
        ],
    ],


    'operation' => [
        'succeeded' => 'Operazione completata con successo',
        'failed' => 'Operazione fallita',
        'not_allowed' => 'Operazione non autorizzata',
        'publish_now' => 'Pubblica adesso',
        'unpublish_now' => 'Rimuovi pubblicazione',
        'publish_later' => 'Pubblica in seguito',
    ],

    'dialogs' => [
        'duplicateDialog' => [
            'title' => 'Warning!',
            'text' => 'Do you really want to duplicate this item?',
            'yes' => 'Yes, duplicate.',
            'no' => 'No, cancel.',
            'success_title' => 'Success!',
            'success' => 'Item successfully duplicated.',
            'error_title' => 'Error!',
            'error' => 'An error has occured.',
        ],
        'deleteDialog' => [
            'title' => 'Warning!',
            'text' => 'Do you really want to delete this item?',
            'yes' => 'Yes, delete.',
            'no' => 'No, cancel.',
            'success_title' => 'Success!',
            'success' => 'Item successfully deleted.',
            'error_title' => 'Error!',
            'error' => 'An error has occured.',
        ],
        'publishNowDialog' => [
            'title' => 'Warning!',
            'text' => 'Do you really want to publish this item now?',
            'yes' => 'Yes, publish now.',
            'no' => 'No, cancel.',
            'success_title' => 'Success!',
            'success' => 'Item successfully published.',
            'error_title' => 'Error!',
            'error' => 'An error has occured.',
        ],
        'unpublishNowDialog' => [
            'title' => 'Warning!',
            'text' => 'Do you really want to unpublish this item now?',
            'yes' => 'Yes, unpublish now.',
            'no' => 'No, cancel.',
            'success_title' => 'Success!',
            'success' => 'Item successfully published.',
            'error_title' => 'Error!',
            'error' => 'An error has occured.',
        ],
        'publishLaterDialog' => [
            'text' => 'Please choose the date when the item should be published:',
            'yes' => 'Save',
            'no' => 'Cancel',
            'success_title' => 'Success!',
            'success' => 'Item was successfully saved.',
            'error_title' => 'Error!',
            'error' => 'An error has occured.',
        ],
    ],

    'btn' => [
        'save' => 'Salva',
        'cancel' => 'Annulla',
        'edit' => 'Modifica',
        'delete' => 'Elimina',
        'search' => 'Cerca',
        'new' => 'Nuovo',
        'saved' => 'Salvata',
        'show' => 'Visualizza',
        'recover' => 'Recupera',
        'export' => "Esporta",
        'show-notes' => 'Note',
        'download' => 'Scarica'
    ],

    'index' => [
        'no_items' => 'Nessun risultato di ricerca',
        'try_changing_items' => 'Prova a modificare i filtri',
        'loading' => 'Caricamento in corso'
    ],

    'listing' => [
        'selected_items' => 'Righe Selezionate',
        'uncheck_all_items' => 'Rimuovi Selezione',
        'check_all_items' => 'Seleziona Tutto',
    ],

    'forms' => [
        'select_a_date' => 'Seleziona data',
        'select_a_time' => 'Seleziona ora',
        'select_date_and_time' => 'Seleziona data e ora',
        'choose_translation_to_edit' => 'Choose translation to edit:',
        'manage_translations' => 'Manage translations',
        'more_can_be_managed' => '({{ otherLocales.length }} more can be managed)',
        'currently_editing_translation' => 'Currently editing {{ this.defaultLocale.toUpperCase() }} (default) translation',
        'hide' => 'Hide Translations',
        'select_an_option' => 'Seleziona un valore',
        'search_an_option' => 'Cerca',
        'search_a_user' => 'Digita per cercare (min. 3 caratteri)',
        'no_result' => 'Nessun risultato',
        'select_options' => 'Seleziona valore',
        'publish' => 'Publish',
        'history' => 'History',
        'created_by' => 'Created by',
        'updated_by' => 'Updated by',
        'created_on' => 'Created on',
        'updated_on' => 'Updated on'
    ],

    'placeholder' => [
        'search' => 'Cerca'
    ],

    'pagination' => [
        'overview' => 'Visualizzazione di {{ pagination.state.from }} di {{ pagination.state.to }} su {{ pagination.state.total }} elementi totali'
    ],

    'logo' => [
        'title' => 'LightCrm',
    ],

    'profile_dropdown' => [
        'profile' => 'Profilo',
        'password' => 'Password',
        'logout' => 'Logout',
        'account' => 'Account',
    ],


    'sidebar' => [
        'content' => 'Menu',
        'settings' => 'Impostazioni',
    ],

    'media_uploader' => [
        'max_number_of_files' => '(max no. di file: :maxNumberOfFiles files)',
        'max_size_pre_file' => '(max dimensione per file: :maxFileSize MB)',

        'private_title' => 'I file non sono accessibili al pubblico',
    ],

    'footer' => [
        'powered_by' => '',
    ],

    'verify_export' => [
        "row" => "Riga CSV",
        "ids" => "Id Agganciati",
        "saved" => "Aggiornato",
        "error" => "Errore Rilevato",
    ],

    'dati-contratto' => [
        'title' => 'Elenco Contratti',

        'actions' => [
            'index' => 'Elenco Contratti',
            'create' => 'Nuovo Contratto',
            'edit' => 'Modifica Contratto - ID: :name',
            'show' => 'Dati Contratto - ID: :name'
        ],

        'columns' => [
            'id' => 'ID',
            'campagna' => 'Campagna',
            'crm_user' => 'Creato Da',
            'update_user' => 'Aggiornato Da',
            'partner' => 'Partner',
            'operatore' => 'Operatore',
            'codice_pratica' => 'Codice Pratica',
            'tipo_inserimento' => 'Tipo Inserimento',
            'tipo_offerta' => 'Tipo Offerta',
            'tipo_contratto' => 'Tipo Contratto',
            'owner_nome'  => 'Nome',
            'owner_cognome' => 'Cognome',
            'owner_dob' => 'Data Nascita',
            'owner_pob' => 'Luogo Nascita',
            'owner_cf' => 'Codice Fiscale',
            'owner_tipo_doc' => 'Tipo Documento',
            'owner_nr_doc' => 'Nr. Documento',
            'owner_ente_doc' => 'Ente Rilascio',
            'owner_doc_data' => 'Data Rilascio',
            'owner_doc_scadenza' => 'Data Scadenza',
            'owner_piva' => 'Partiva Iva',
            'owner_rag_soc' => 'Ragione Sociale',
            'owner_email' => 'Email',
            'telefono' => 'Telefono 1',
            'cellulare' => 'Telefono 2',
            'owner_indirizzo' => 'Indirizzo',
            'owner_civico' => 'Num',
            'owner_comune' => 'Comune',
            'owner_prov' => 'Prov.',
            'owner_cap' => 'Cap',
            'owner_az_nome_societa' => 'Nome Azienda',
            'owner_az_codice_business' => 'Codice Business',
            'owner_az_comune' => 'Comune',
            'owner_az_prov' => 'Prov.',
            'owner_az_cap' => 'Cap',
            'forn_indirizzo' => 'Indirizzo',
            'forn_civico' => 'Num',
            'forn_comune' => 'Comune',
            'forn_prov' => 'Prov.',
            'forn_cap' => 'Cap',
            'fatt_indirizzo' => 'Indirizzo',
            'fatt_civico' => 'Num',
            'fatt_comune' => 'Comune',
            'fatt_prov' => 'Prov.',
            'fatt_cap' => 'Cap',
            'mod_pagamento' => 'Mod. Pagamento',
            'sdd_iban' => 'Iban',
            'sdd_ente' => 'Ente',
            'sdd_intestatario' => 'Intestatario',
            'sdd_cf' => 'Codice Fiscale',
            'delega' => 'Delega',
            'delega_nome' => 'Nome',
            'delega_cognome' => 'Cognome',
            'delega_dob' => 'Data Nascita',
            'delega_pob' => 'Luogo Nascita',
            'delega_cf' => 'Codice Fiscale',
            'delega_tipo_doc' => 'Tipo Documento',
            'delega_nr_doc' => 'Nr. Documento',
            'delega_ente_doc' => 'Ente Rilascio',
            'delega_doc_data' => 'Data Rilascio',
            'delega_doc_scadenza' => 'Data Scadenza',
            'delega_tipo_rapporto' => 'Tipo Rapporto',
            'titolarita_immobile' => 'Titolarità Immobile',
            'offerta_luce' => 'Off. Luce',
            'offerta_gas' => 'Off. Gas',
            'luce_polizza' => 'Polizza Luce',
            'luce_pod' => 'POD',
            'luce_kw' => 'KW',
            'luce_tensione' => 'Tensione',
            'luce_consumo' => 'Consumo',
            'luce_fornitore' => 'Fornitore',
            'luce_mercato' => 'Mercato',
            'gas_polizza' => 'Polizza Gas',
            'gas_polizza_caldaia' => 'Polizza Caldaia',
            'gas_pdr' => 'PDR',
            'gas_consumo' => 'Consumo',
            'gas_fornitore' => 'Fornitore',
            'gas_matricola' => 'Matricola',
            'gas_remi' => 'REMI',
            'gas_mercato' => 'Mercato',
            'tel_offerta' => 'Offerta Telefono',
            'tel_cod_mig_voce' => 'Cod. Mig. Voce',
            'tel_cod_mig_adsl' => 'Cod. Mig. ADSL',
            'tel_cellulare_assoc' => 'Numero Associato',
            'tel_fornitore' => 'Fornitore',
            'tel_tipo_linea' => 'Tipo Linea',
            'tel_iccd' => 'ICCD',
            'tel_scadenza_telecom' => 'Scadenza Telecom',
            'tel_passaggio_numero' => 'Numero Passaggio',
            'tel_tipo_passaggio' => 'Passaggio',
            'tel_canone' => 'Canone',
            'tel_finanziamento' => 'Finanziamento',
            'tel_sell_smartphone' => 'Vendita Smartphone',
            'tel_gia_cliente' => "Già Cliente",
            'note_ope' => 'Note Operatore',
            'note_bo' => 'Note BO',
            'note_sv' => 'Note Supervisor',
            'note_verifica' => 'Note Verifica',
            'esito' => 'Esito',
            'created_at' => 'Data Contratto',
            'updated_at' => 'Ultima Modifica',
            'deleted_at' => 'Data Cancellazione',
            'id_rec' => 'Id Rec',
            'tipo_fatturazione' => 'Tipo Fatturazione',
            'tipo_fatturazione_email' => 'Email',
            'tipo_fatturazione_cartaceo' => 'Cartaceo',
            'fascia_reperibilita' => 'Fascia Reperibilità',
            'nome_intestatario' => 'Intestato A',
            'recall_at' => 'Richiamo',
            'recover_at' => 'Data Recupero',
            'lista' => 'Lista',
            'contatti' => 'Contatti',
            'id_linea' => 'Id Linea'
        ],

        'export-columns' => [
            'id' => 'ID',
            'campagna' => 'Campagna',
            'crm_user' => 'Creato Da',
            'update_user' => 'Ultimo Aggiornamento Da',
            'partner' => 'Partner',
            'operatore' => 'Operatore',
            'codice_pratica' => 'Codice Pratica',
            'tipo_inserimento' => 'Tipo Inserimento',
            'tipo_offerta' => 'Tipo Offerta',
            'tipo_contratto' => 'Tipo Contratto',
            'owner_nome'  => 'Intestatario: Nome',
            'owner_cognome' => 'Intestatario: Cognome',
            'owner_dob' => 'Intestatario: Data Nascita',
            'owner_pob' => 'Intestatario: Luogo Nascita',
            'owner_cf' => 'Intestatario: Codice Fiscale',
            'owner_tipo_doc' => 'Intestatario: Tipo Documento',
            'owner_nr_doc' => 'Intestatario: Nr. Documento',
            'owner_ente_doc' => 'Intestatario: Ente Rilascio Doc.',
            'owner_doc_data' => 'Intestatario: Data Rilascio Doc.',
            'owner_doc_scadenza' => 'Intestatario: Data Scadenza Doc.',
            'owner_piva' => 'Partiva Iva',
            'owner_rag_soc' => 'Ragione Sociale',
            'owner_email' => 'Email Intestatario',
            'telefono' => 'Telefono 1',
            'cellulare' => 'Telefono 2',
            'owner_indirizzo' => 'Intestatario: Indirizzo',
            'owner_civico' => 'Intestatario: Civico',
            'owner_comune' => 'Intestatario: Comune',
            'owner_prov' => 'Intestatario: Prov.',
            'owner_cap' => 'Intestatario: Cap',
            'owner_az_nome_societa' => 'Nome Azienda',
            'owner_az_codice_business' => 'Codice Business',
            'owner_az_comune' => 'Azienda: Comune',
            'owner_az_prov' => 'Azienda: Prov.',
            'owner_az_cap' => 'Azienda: Cap',
            'forn_indirizzo' => 'Fornitura: Indirizzo',
            'forn_civico' => 'Fornitura: Civico',
            'forn_comune' => 'Fornitura: Comune',
            'forn_prov' => 'Fornitura: Prov.',
            'forn_cap' => 'Fornitura: Cap',
            'fatt_indirizzo' => 'Fatturazione: Indirizzo',
            'fatt_civico' => 'Fatturazione: Civico',
            'fatt_comune' => 'Fatturazione: Comune',
            'fatt_prov' => 'Fatturazione: Prov.',
            'fatt_cap' => 'Fatturazione: Cap',
            'mod_pagamento' => 'Mod. Pagamento',
            'sdd_iban' => 'SDD: Iban',
            'sdd_ente' => 'SDD: Ente',
            'sdd_intestatario' => 'SDD: Intestatario',
            'sdd_cf' => 'SDD: Codice Fiscale',
            'delega' => 'Pag: Delega',
            'delega_nome' => 'Delega: Nome',
            'delega_cognome' => 'Delega: Cognome',
            'delega_dob' => 'Delega: Data Nascita',
            'delega_pob' => 'Delega: Luogo Nascita',
            'delega_cf' => 'Delega: Codice Fiscale',
            'delega_tipo_doc' => 'Delega: Tipo Doc.',
            'delega_nr_doc' => 'Delega: Nr. Doc.',
            'delega_ente_doc' => 'Delega: Ente Doc.',
            'delega_doc_data' => 'Delega: Data Rilascio Doc.',
            'delega_doc_scadenza' => 'Delega: Data Scadenza Doc.',
            'delega_tipo_rapporto' => 'Delega: Tipo Rapporto',
            'titolarita_immobile' => 'Titolarità Immobile',
            'offerta_luce' => 'Off. Luce',
            'offerta_gas' => 'Off. Gas',
            'luce_polizza' => 'Polizza Luce',
            'luce_pod' => 'Luce: POD',
            'luce_kw' => 'Luce: KW',
            'luce_tensione' => 'Luce: Tensione',
            'luce_consumo' => 'Luce: Consumo',
            'luce_fornitore' => 'Luce: Fornitore',
            'luce_mercato' => 'Luce: Mercato',
            'gas_polizza' => 'Polizza Gas',
            'gas_polizza_caldaia' => 'Polizza Caldaia',
            'gas_pdr' => 'Gas: PDR',
            'gas_consumo' => 'Gas: Consumo',
            'gas_fornitore' => 'Gas: Fornitore',
            'gas_matricola' => 'Gas: Matricola',
            'gas_remi' => 'Gas: REMI',
            'gas_mercato' => 'Gas: Mercato',
            'tel_offerta' => 'Offerta Telefono',
            'tel_cod_mig_voce' => 'Cod. Mig. Voce',
            'tel_cod_mig_adsl' => 'Cod. Mig. ADSL',
            'tel_cellulare_assoc' => 'Tel: Numero Associato',
            'tel_fornitore' => 'Tel: Fornitore',
            'tel_tipo_linea' => 'Tel: Tipo Linea',
            'tel_iccd' => 'Tel: ICCD',
            'tel_scadenza_telecom' => 'Scadenza Telecom',
            'tel_passaggio_numero' => 'Numero Passaggio',
            'tel_tipo_passaggio' => 'Passaggio',
            'tel_canone' => 'Canone',
            'tel_finanziamento' => 'Finanziamento',
            'tel_sell_smartphone' => 'Vendita Smartphone',
            'tel_gia_cliente' => "Già Cliente",
            'note_ope' => 'Note Operatore',
            'note_bo' => 'Note BO',
            'note_sv' => 'Note Supervisor',
            'note_verifica' => "Note Verifica",
            'esito' => 'Esito',
            'created_at' => 'Data Inserimento',
            'updated_at' => 'Ultima Modifica',
            'deleted_at' => 'Data Cancellazione',
            'id_rec' => 'Id Rec',
            'tipo_fatturazione' => 'Tipo Fatturazione',
            'tipo_fatturazione_email' => 'Tipo Fatt: Email',
            'tipo_fatturazione_cartaceo' => 'Tipo Fatt: Cartaceo',
            'fascia_reperibilita' => 'Fascia Reperibilità',
            'recall_at' => 'Data Richiamo',
            'recover_at' => 'Data Recupero',
            'mese_creazione' => 'Mese Inserimento',
            'anno_creazione' => 'Anno Inserimento',
            'lista' => 'Lista'
        ],
    ],

    'esito' => [
        'title' => 'Esito',

        'actions' => [
            'index' => 'Elenco Esito',
            'create' => 'Nuovo Esito',
            'edit' => 'Modifica :name',
            'manage' => 'Gestione Esiti',
        ],

        'columns' => [
            'id' => 'ID',
            'nome' => 'Nome',
            'cod' => 'Cod',
            'is_new' => 'Nuovo Contratto',
            'is_final' => 'Esito Finale',
            'is_ok' => 'Esito Positivo',
            'is_not_ok' => 'Esito Negativo',
            'is_recover' => 'Recuperato'
        ],
    ],

    'recording-log' => [
        'title' => 'Registrazioni',

        'actions' => [
            'index' => 'Elenco Registrazioni Telefoniche',
        ],

        'columns' => [
            'id' => 'ID',
            'recording_id' => 'ID',
            'channel' => 'Canale',
            'server_ip' => 'IP Server',
            'extension' => 'Extensione',
            'start_time' => 'Ora Inizio',
            'start_epoch' => 'TS Inizio',
            'end_time' => 'Ora Fine',
            'end_epoch' => 'TS Fine',
            'length_in_sec' => 'Durata Sec.',
            'length_in_min' => 'Durata Min.',
            'filename' => 'Nome File',
            'location' => 'Percorso',
            'lead_id' => 'Lead',
            'user' => 'Utente',
            'vicidial_id' => 'ID Vicidial',
            'telefono' => 'Telefono',
            'campagna' => 'Campagna'
        ],
    ],

    'headermenu'=>[
        'dashboard' => "Home",
        'contratti' => 'Contratti',
        'personal_ko' => 'Elenco KO',
        'assegnazioni' => 'Assegnazioni',
        'admin' => 'Amministrazione',
        'stats_rec_server' => 'Telefonia',
        'stats_crm' => 'Statistiche CRM'
    ],

    'sys-setting' => [
        'title' => 'Impostazioni di Sistema',

        'actions' => [
            'index' => 'Elenco Impostazioni',
            'create' => 'Nuova Chiave',
            'edit' => 'Modifica :name',
        ],

        'columns' => [
            'id' => 'ID',
            'crm_user' => 'Utente',
            'key' => 'Chiave',
            'value' => 'Valore'
        ],
    ],



    'rec-server' => [
        'title' => 'Rec. Server',

        'actions' => [
            'index' => 'Elenco Rec. Server',
            'create' => 'Aggiungi Rec. Server',
            'edit' => 'Modifica :name',
            'manage' => 'Gestione Rec. Server',
        ],

        'columns' => [
            'id' => 'ID',
            'name' => 'Nome',
            'type' => 'Tipo Server',
            'db_driver' => 'Driver DB',
            'db_host' => 'Host DB',
            'db_port' => 'Porta DB',
            'db_user' => 'DB User',
            'db_name' => 'DB Name',
            'db_password' => 'DB Password',
            'db_rewrite_host' => 'Sovrascrivi url',
            'db_rewrite_search' => 'Da Sovrascrivere',
            'db_rewrite_replace' => 'Sovrascrivi con',
        ],
    ],


    'vicidial-agent-log' => [
        'title' => 'Statistiche Chiamata',

        'actions' => [
            'index' => 'Tempi Chiamata',
            'stat_log' => "Esiti Chiamata"
        ],

        'columns' => [
            'agent_log_id' => "ID",
            'user' => "User ID",
            'server_ip' => "Server",
            'event_time' => "Evento",
            'campaign_id' => "Campagna",
            'pause_sec' => "Pausa",
            'wait_sec' => "Attesa",
            'talk_sec' => "Conversazione",
            'after_call_work' => 'A.C.W.', //After Call Work
            'dispo_sec' => "Dispo",
            'status' => "Status",
            'user_group' => "User Group",
            'dead_sec' => "Dead",
            'pause_hour' => "Pausa",
            'wait_hour' => "Attesa",
            'talk_hour' => "Conversazione",
            'after_call_work_hour' => 'Dopo Chiamata (ACW)',

            'pause_perc' => "Pausa",
            'wait_perc' => "Attesa",
            'talk_perc' => "Conversazione",
            'after_call_work_perc' => 'A.C.W.', //After Call Work

            'login_time_hour' => 'Login Time',
            'effective_time_hour' => 'Retribuito',
            'uniqueid' => "UID",
            'pause_type' => "Tipo Pausa",
            'login_time' => 'Login Time',
            'effective_time' => 'Retribuito',
            'calls' => 'Chiamate',
            'full_name' => 'Utente',
            'userinfo' => 'Utente'

        ],
    ],


    'user-timelog' => [
        'title' => 'Registrazione Ore Utente',

        'actions' => [
            'index' => 'Elenco Ore',
            'create' => 'Aggiungi Ore',
            'edit' => 'Modifica Ore',
            'manage' => 'Inserimento Ore',
            'stats' => 'Statistiche Operatori'
        ],

        'columns' => [
            'id' => 'ID',
            'ore' => 'Ore',
            'minuti' => 'Minuti',
            'user' => 'Utente',
            'campagna' => 'Campagna',
            'period' => 'Data',
            'id_user' => 'Id Utente',
            'pezzi' => 'Pezzi',
            'resa' => 'Resa (Ore/Pezzi)'
        ],
    ],


    'user-performance' => [
        'title' => 'Rese Operatore - Inserimenti/Ore',

        'actions' => [
            'index' => 'Rese Operatore',
            'manage' => 'Rese Operatore',
            'stats' => 'Rese Operatore'
        ],

        'columns' => [
            'id' => 'ID Utente',
            'ore' => 'Ore',
            'user' => 'Utente',
            'full_name' => 'Utente',
            'user_email' => 'ID Login',
            'email' => 'ID Login',
            'id_user' => 'Id Utente',
            'pezzi' => 'Pezzi',
            'pezzi_singoli' => 'Tot Singoli',
            'pezzi_singoli_lordo' => 'Tot Singoli Lordo',
            'pezzi_dual' => 'Tot Dual',
            'pezzi_dual_lordo' => 'Tot Dual Lordo',
            'pezzi_energia' => 'Tot Energia',
            'pezzi_energia_lordo' => 'Tot Energia Lordo',
            'pezzi_fisso' => 'Tot Fisso',
            'pezzi_fisso_lordo' => 'Tot Fisso Lordo',
            'pezzi_mobile' => 'Tot Mobile',
            'pezzi_mobile_lordo' => 'Tot Mobile Lordo',
            'pezzi_telefonia' => 'Tot Telefonia',
            'pezzi_telefonia_lordo' => 'Tot Telefonia Lordo',
            'pezzi_tot' => 'Pezzi Totali',
            'pezzi_tot_lordo' => 'Pezzi Totali Lordo',
            'resa' => 'Resa (Pezzi Tot/Ore)',
            'resa_lordo' => 'Resa (Pezzi Tot/Ore) Lordo',
            'partner' => 'Partner'
        ],
    ],

    'statistiche-esiti' => [
        'title' => 'Esiti Contratti',

        'actions' => [
            'index' => 'Esiti Contratti',
            'manage' => 'Esiti Contratti',
            'stats' => 'Esiti Contratti'
        ],

        'columns' => [
            'id' => 'ID Esito',
            'esito' => 'Esito',
            'stato' => 'Stato',
            'campagna' => 'Campagna',
            'partner' => 'Partner',
            'crm_user' => 'Operatore',
            'partial_total' => 'Schede',
            'partial_total_pz' => 'Pezzi',
            'totale' => 'Pezzi Gruppo',
            'totale_pezzi' => 'Pezzi Totali',
            'totale_globale' => 'Schede Totali'
        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];
