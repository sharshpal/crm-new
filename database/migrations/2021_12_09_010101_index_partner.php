<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IndexPartner extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('partner', function (Blueprint $table) {
            $table->index('id');
            $table->index('nome');
            $table->index('vc_usergroup');
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
        Schema::table('campagna', function (Blueprint $table) {

            $table->dropIndex('id');
            $table->dropIndex('nome');
            $table->dropIndex('vc_usergroup');
            $table->dropIndex('created_at');
            $table->dropIndex('updated_at');
            $table->dropIndex('deleted_at');
        });
    }
}
