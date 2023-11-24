<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class IndexUserTimelog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_timelog', function (Blueprint $table) {
            $table->index('id');
            $table->index('ore');
            $table->index('minuti');
            $table->index('user');
            $table->index('campagna');
            $table->index('period');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_timelog', function (Blueprint $table) {

            $table->dropIndex('id');
            $table->dropIndex('ore');
            $table->dropIndex('minuti');
            $table->dropIndex('user');
            $table->dropIndex('campagna');
            $table->dropIndex('period');
        });
    }
}
