<?php

/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(\App\Models\CrmUser::class, function (Faker\Generator $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->email,
        'password' => bcrypt($faker->password),
        'remember_token' => null,
        'activated' => true,
        'forbidden' => $faker->boolean(),
        'language' => 'en',
        'deleted_at' => null,
        'created_at' => $faker->dateTime,
        'updated_at' => $faker->dateTime,
        'last_login_at' => $faker->dateTime,

    ];
});/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Partner::class, static function (Faker\Generator $faker) {
    return [
        'nome' => $faker->sentence,


    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Campagna::class, static function (Faker\Generator $faker) {
    return [
        'nome' => $faker->sentence,


    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\Esito::class, static function (Faker\Generator $faker) {
    return [
        'nome' => $faker->sentence,


    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\DatiContratto::class, static function (Faker\Generator $faker) {
    return [
        'campagna' => $faker->randomNumber(5),
        'crm_user' => $faker->randomNumber(5),
        'partner' => $faker->randomNumber(5),
        'codice_pratica' => $faker->sentence,
        'tipo_inserimento' => $faker->sentence,
        'owner_nome' => $faker->sentence,
        'owner_cognome' => $faker->sentence,
        'owner_dob' => $faker->sentence,
        'owner_pob' => $faker->sentence,
        'owner_cf' => $faker->sentence,
        'owner_tipo_doc' => $faker->sentence,
        'owner_nr_doc' => $faker->sentence,
        'owner_ente_doc' => $faker->sentence,
        'owner_doc_data' => $faker->sentence,
        'owner_doc_scadenza' => $faker->sentence,
        'owner_piva' => $faker->sentence,
        'owner_rag_soc' => $faker->sentence,
        'telefono' => $faker->sentence,
        'cellulare' => $faker->sentence,
        'owner_indirizzo' => $faker->sentence,
        'owner_civico' => $faker->sentence,
        'owner_comune' => $faker->sentence,
        'owner_prov' => $faker->sentence,
        'owner_cap' => $faker->sentence,
        'forn_indirizzo' => $faker->sentence,
        'forn_civico' => $faker->sentence,
        'forn_comune' => $faker->sentence,
        'forn_prov' => $faker->sentence,
        'forn_cap' => $faker->sentence,
        'fatt_indirizzo' => $faker->sentence,
        'fatt_civico' => $faker->sentence,
        'fatt_comune' => $faker->sentence,
        'fatt_prov' => $faker->sentence,
        'fatt_cap' => $faker->sentence,
        'mod_pagamento' => $faker->sentence,
        'sdd_iban' => $faker->sentence,
        'sdd_ente' => $faker->sentence,
        'sdd_intestatario' => $faker->sentence,
        'sdd_cf' => $faker->sentence,
        'delega' => $faker->boolean(),
        'delega_nome' => $faker->sentence,
        'delega_cognome' => $faker->sentence,
        'delega_dob' => $faker->sentence,
        'delega_pob' => $faker->sentence,
        'delega_cf' => $faker->sentence,
        'delega_tipo_doc' => $faker->sentence,
        'delega_nr_doc' => $faker->sentence,
        'delega_ente_doc' => $faker->sentence,
        'delega_doc_data' => $faker->sentence,
        'delega_doc_scadenza' => $faker->sentence,
        'delega_tipo_rapporto' => $faker->sentence,
        'titolarita_immobile' => $faker->sentence,
        'offerta_luce' => $faker->boolean(),
        'offerta_gas' => $faker->boolean(),
        'luce_polizza' => $faker->boolean(),
        'luce_pod' => $faker->sentence,
        'luce_kw' => $faker->sentence,
        'luce_tensione' => $faker->sentence,
        'luce_consumo' => $faker->sentence,
        'luce_fornitore' => $faker->sentence,
        'luce_mercato' => $faker->sentence,
        'gas_pdr' => $faker->sentence,
        'gas_consumo' => $faker->sentence,
        'gas_fornitore' => $faker->sentence,
        'gas_matricola' => $faker->sentence,
        'gas_remi' => $faker->sentence,
        'gas_mercato' => $faker->sentence,
        'tel_offerta' => $faker->sentence,
        'tel_cod_mig_voce' => $faker->sentence,
        'tel_cod_mig_adsl' => $faker->sentence,
        'tel_cellulare_assoc' => $faker->sentence,
        'tel_fornitore' => $faker->sentence,
        'note_ope' => $faker->text(),
        'note_bo' => $faker->text(),
        'note_sv' => $faker->text(),
        'esito' => $faker->randomNumber(5),


    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\RecordingLog::class, static function (Faker\Generator $faker) {
    return [
        'recording_id' => $faker->randomNumber(5),
        'channel' => $faker->sentence,
        'server_ip' => $faker->sentence,
        'extensions' => $faker->sentence,
        'start_time' => $faker->dateTime,
        'start_epoch' => $faker->randomNumber(5),
        'end_time' => $faker->dateTime,
        'end_epoch' => $faker->randomNumber(5),
        'length_in_sec' => $faker->randomNumber(5),
        'length_in_min' => $faker->randomFloat,
        'filename' => $faker->sentence,
        'location' => $faker->sentence,
        'lead_id' => $faker->randomNumber(5),
        'user' => $faker->sentence,
        'vicidial_id' => $faker->sentence,


    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\SysSetting::class, static function (Faker\Generator $faker) {
    return [
        'crm_user' => $faker->randomNumber(5),

        'settings' => ['en' => $faker->sentence],

    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\SysSetting::class, static function (Faker\Generator $faker) {
    return [


    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\SysSetting::class, static function (Faker\Generator $faker) {
    return [
        'crm_user' => $faker->randomNumber(5),
        'settings' => $faker->text(),


    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\SysSetting::class, static function (Faker\Generator $faker) {
    return [
        'crm_user' => $faker->randomNumber(5),
        'key' => $faker->sentence,
        'value' => $faker->text(),


    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\VicidialServer::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'db_host' => $faker->sentence,
        'db_port' => $faker->sentence,
        'db_user' => $faker->sentence,
        'db_password' => $faker->sentence,
        'db_rewrite_host' => $faker->boolean(),
        'db_rewrite_search' => $faker->sentence,
        'db_rewrite_replace' => $faker->sentence,


    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\RecServer::class, static function (Faker\Generator $faker) {
    return [
        'name' => $faker->firstName,
        'type' => $faker->sentence,
        'db_host' => $faker->sentence,
        'db_port' => $faker->sentence,
        'db_name' => $faker->sentence,
        'db_user' => $faker->sentence,
        'db_password' => $faker->sentence,
        'db_rewrite_host' => $faker->boolean(),
        'db_rewrite_search' => $faker->sentence,
        'db_rewrite_replace' => $faker->sentence,


    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\VicidialAgentLog::class, static function (Faker\Generator $faker) {
    return [
        'agent_log_id' => $faker->randomNumber(5),
        'user' => $faker->sentence,
        'server_ip' => $faker->sentence,
        'event_time' => $faker->dateTime,
        'campaign_id' => $faker->sentence,
        'pause_sec' => $faker->sentence,
        'wait_sec' => $faker->sentence,
        'talk_sec' => $faker->sentence,
        'dispo_sec' => $faker->sentence,
        'status' => $faker->sentence,
        'user_group' => $faker->sentence,
        'dead_sec' => $faker->sentence,
        'uniqueid' => $faker->sentence,
        'pause_type' => $faker->sentence,


    ];
});
/** @var  \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\Models\UserTimelog::class, static function (Faker\Generator $faker) {
    return [
        'ore' => $faker->randomNumber(5),
        'minuti' => $faker->randomNumber(5),
        'user' => $faker->randomNumber(5),
        'campagna' => $faker->randomNumber(5),
        'period' => $faker->date(),
        
        
    ];
});
