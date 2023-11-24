<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IndexCrmUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('crm_user', function (Blueprint $table) {

            $table->index('id');
            $table->index('first_name');
            $table->index('last_name');

            $table->index('email');
            //$table->index('password');
            $table->index('activated');
            $table->index('forbidden');
            $table->index('language');

            $table->index('created_at');
            $table->index('updated_at');
            $table->index('deleted_at');

            $table->index('last_login_at');
            //$table->index('ipfilter');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('crm_user', function (Blueprint $table) {

            $table->dropIndex('id');
            $table->dropIndex('nome');
            $table->dropIndex('cod');

            $table->dropIndex('is_final');
            $table->dropIndex('is_new');
            $table->dropIndex('is_ok');
            $table->dropIndex('is_recover');
            $table->dropIndex('is_ok');

            $table->dropIndex('created_at');
            $table->dropIndex('updated_at');
            $table->dropIndex('deleted_at');
        });
    }
}
