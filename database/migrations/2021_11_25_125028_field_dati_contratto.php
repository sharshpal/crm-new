<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FieldDatiContratto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dati_contratto', function (Blueprint $table) {

            $table->string('lista')->nullable();
            $table->string('tel_tipo_passaggio')->nullable();
            $table->string('tel_passaggio_numero')->nullable();
            $table->boolean('tel_finanziamento')->default(false);
            $table->string('tel_canone',45)->nullable();
            $table->boolean('tel_sell_smartphone')->default(false);
            $table->boolean('tel_gia_cliente')->default(false);
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
            $table->dropColumn(['lista','tel_tipo_passaggio','tel_passaggio_numero','tel_finanziamento','tel_canone','tel_sell_smartphone']);
        });
    }
}
