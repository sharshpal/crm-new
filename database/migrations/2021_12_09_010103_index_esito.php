<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IndexEsito extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('esito', function (Blueprint $table) {

            $table->index('id');
            $table->index('nome');
            $table->index('cod');

            $table->index('is_final');
            $table->index('is_new');
            $table->index('is_ok');
            $table->index('is_recover');

            $table->index('created_at');
            $table->index('updated_at');
            $table->index('deleted_at');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('esito', function (Blueprint $table) {

            $table->dropIndex('id');
            $table->dropIndex('nome');
            $table->dropIndex('cod');

            $table->dropIndex('is_final');
            $table->dropIndex('is_new');
            $table->dropIndex('is_ok');
            $table->dropIndex('is_recover');

            $table->dropIndex('created_at');
            $table->dropIndex('updated_at');
            $table->dropIndex('deleted_at');
        });
    }
}
