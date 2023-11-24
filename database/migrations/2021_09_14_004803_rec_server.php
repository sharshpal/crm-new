<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RecServer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rec_server', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('type',45);
            $table->string('db_driver',45);
            $table->string('db_host');
            $table->string('db_port',10);
            $table->string('db_name');
            $table->string('db_user',45);
            $table->string('db_password',45);
            $table->boolean('db_rewrite_host')->default(false);
            $table->string('db_rewrite_search')->nullable()->default(null);
            $table->string('db_rewrite_replace')->nullable()->default(null);
            $table->timestamp('created_at')->nullable()->default(null);
            $table->timestamp('updated_at')->nullable()->default(null);
            $table->timestamp('deleted_at')->nullable()->default(null);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('rec_server');
    }
}
