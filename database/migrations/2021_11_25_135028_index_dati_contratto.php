<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IndexDatiContratto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dati_contratto', function (Blueprint $table) {

            $table->index('id');
            $table->index('created_at');
            $table->index('updated_at');
            $table->index('deleted_at');
            $table->index('recover_at');
            $table->index('campagna');
            $table->index('crm_user');
            $table->index('update_user');
            $table->index('partner');
            $table->index('codice_pratica');
            $table->index('esito');
            $table->index('owner_nome');
            $table->index('owner_cognome');
            $table->index('owner_cf');
            $table->index('luce_pod');
            $table->index('gas_pdr');
            $table->index('tipo_inserimento');
            $table->index('tipo_offerta');
            $table->index('tipo_contratto');
            $table->index('tipo_fatturazione');
            $table->index('tipo_fatturazione_cartaceo');
            $table->index('tipo_fatturazione_email');

            $table->index('owner_piva');
            $table->index('owner_rag_soc');
            $table->index('owner_email');
            $table->index('telefono');
            $table->index('cellulare');

            $table->index('owner_az_nome_societa');
            $table->index('owner_az_codice_business');


            $table->index('mod_pagamento');

            $table->index('delega_nome');
            $table->index('delega_cognome');
            $table->index('delega_cf');


            $table->index('luce_fornitore');
            $table->index('luce_mercato');

            $table->index('gas_remi');
            $table->index('gas_mercato');

            $table->index('tel_offerta');
            $table->index('tel_cod_mig_voce');
            $table->index('tel_cod_mig_adsl');
            $table->index('tel_cellulare_assoc');
            $table->index('tel_tipo_linea');

            $table->index('tel_tipo_passaggio');
            $table->index('tel_passaggio_numero');
            $table->index('tel_finanziamento');
            $table->index('tel_sell_smartphone');
            //$table->index('note_ope');
            //$table->index('note_bo');
            //$table->index('note_sv');
            //$table->index('note_verifica');
            $table->index('id_rec');

            $table->index('recall_at');
            $table->index('lista');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dati_contratto', function (Blueprint $table) {

            $table->dropIndex('created_at');
            $table->dropIndex('updated_at');
            $table->dropIndex('deleted_at');
            $table->dropIndex('recover_at');
            $table->dropIndex('campagna');
            $table->dropIndex('crm_user');
            $table->dropIndex('update_user');
            $table->dropIndex('partner');
            $table->dropIndex('codice_pratica');
            $table->dropIndex('esito');
            $table->dropIndex('owner_nome');
            $table->dropIndex('owner_cognome');
            $table->dropIndex('owner_cf');
            $table->dropIndex('luce_pod');
            $table->dropIndex('gas_pdr');
            $table->dropIndex('tipo_inserimento');
            $table->dropIndex('tipo_offerta');
            $table->dropIndex('tipo_contratto');
            $table->dropIndex('tipo_fatturazione');
            $table->dropIndex('tipo_fatturazione_cartaceo');
            $table->dropIndex('tipo_fatturazione_email');

            $table->dropIndex('owner_piva');
            $table->dropIndex('owner_rag_soc');
            $table->dropIndex('owner_email');
            $table->dropIndex('telefono');
            $table->dropIndex('cellulare');

            $table->dropIndex('owner_az_nome_societa');
            $table->dropIndex('owner_az_codice_business');


            $table->dropIndex('mod_pagamento');

            $table->dropIndex('delega_nome');
            $table->dropIndex('delega_cognome');
            $table->dropIndex('delega_cf');


            $table->dropIndex('luce_fornitore');
            $table->dropIndex('luce_mercato');

            $table->dropIndex('gas_remi');
            $table->dropIndex('gas_mercato');

            $table->dropIndex('tel_offerta');
            $table->dropIndex('tel_cod_mig_voce');
            $table->dropIndex('tel_cod_mig_adsl');
            $table->dropIndex('tel_cellulare_assoc');
            $table->dropIndex('tel_tipo_linea');

            $table->dropIndex('tel_tipo_passaggio');
            $table->dropIndex('tel_passaggio_numero');
            $table->dropIndex('tel_finanziamento');
            $table->dropIndex('tel_sell_smartphone');
            //$table->dropIndex('note_ope');
            //$table->dropIndex('note_bo');
            //$table->dropIndex('note_sv');
            //$table->dropIndex('note_verifica');
            $table->dropIndex('id_rec');

            $table->dropIndex('recall_at');
            $table->dropIndex('lista');
        });
    }
}
