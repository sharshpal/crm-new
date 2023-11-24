<?php

return [


    'page_title_suffix' => 'Crm',

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
            'campaigns' => 'Campagne Visibili',
            'partners' => 'Partner Visibili',
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
    ],

    'index' => [
        'no_items' => 'Nessun risultato di ricerca',
        'try_changing_items' => 'Prova a modificare i filtri',
    ],

    'listing' => [
        'selected_items' => 'Selected items',
        'uncheck_all_items' => 'Uncheck all items',
        'check_all_items' => 'Check all items',
    ],

    'forms' => [
        'select_a_date' => 'Select date',
        'select_a_time' => 'Select time',
        'select_date_and_time' => 'Select date and time',
        'choose_translation_to_edit' => 'Choose translation to edit:',
        'manage_translations' => 'Manage translations',
        'more_can_be_managed' => '({{ otherLocales.length }} more can be managed)',
        'currently_editing_translation' => 'Currently editing {{ this.defaultLocale.toUpperCase() }} (default) translation',
        'hide' => 'Hide Translations',
        'select_an_option' => 'Seleziona un valore',
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

    'dati-contratto' => [
        'title' => 'Elenco Contratti',

        'actions' => [
            'index' => 'Elenco Contratti',
            'create' => 'Nuovo Contratto',
            'edit' => 'Modifica :name',
        ],

        'columns' => [
            'id' => 'ID',
            'campagna' => 'Campagna',
            'crm_user' => 'Utente',
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
            'telefono' => 'Telefono',
            'cellulare' => 'Cellulare',
            'owner_indirizzo' => 'Indirizzo',
            'owner_civico' => 'Civico',
            'owner_comune' => 'Comune',
            'owner_prov' => 'Prov.',
            'owner_cap' => 'Cap',
            'owner_az_nome_societa' => 'Nome Azienda',
            'owner_az_codice_business' => 'Codice Business',
            'owner_az_comune' => 'Comune',
            'owner_az_prov' => 'Prov.',
            'owner_az_cap' => 'Cap',
            'forn_indirizzo' => 'Indirizzo',
            'forn_civico' => 'Civico',
            'forn_comune' => 'Comune',
            'forn_prov' => 'Prov.',
            'forn_cap' => 'Cap',
            'fatt_indirizzo' => 'Indirizzo',
            'fatt_civico' => 'Civico',
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
            'delega_ente_doc' => 'Ente',
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
            'tel_cellulare_assoc' => 'Cellulare Associato',
            'tel_fornitore' => 'Fornitore',
            'tel_tipo_linea' => 'Tipo Linea',
            'tel_iccd' => 'ICCD',
            'tel_scadenza_telecom' => 'Scadenza Telecom',
            'note_ope' => 'Note Operatore',
            'note_bo' => 'Note BO',
            'note_sv' => 'Note Supervisor',
            'esito' => 'Esito',
            'created_at' => 'Data Inserimento',
            'id_rec' => 'Id Rec',
            'tipo_fatturazione' => 'Tipo Fatturazione',
            'tipo_fatturazione_email' => 'Email',
            'tipo_fatturazione_cartaceo' => 'Cartaceo',
            'fascia_reperibilita' => 'Fascia Reperibilità'
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
            'is_new' => 'Esito Nuovo Contratto',
            'is_final' => 'Esito Finale'
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
        'contratti' => 'Contracts',
        'personal_ko' => 'KO List',
        'assegnazioni' => 'Assign',
        'admin' => 'Administration'
    ],

    'sys-setting' => [
        'title' => 'System Settings',

        'actions' => [
            'index' => 'Settings List',
            'create' => 'New Setting',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'crm_user' => 'User',
            'key' => 'Key',
            'value' => 'Value'
        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];
