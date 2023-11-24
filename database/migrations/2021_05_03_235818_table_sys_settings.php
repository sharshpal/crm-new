<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableSysSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sys_settings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('crm_user')->nullable();
            $table->string('key');
            $table->text('value');

            $table->foreign('crm_user')
                ->references('id')
                ->on("crm_user")
                ->onDelete('cascade');

            $table->unique(["crm_user","key"]);
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("sys_settings");
    }
}
