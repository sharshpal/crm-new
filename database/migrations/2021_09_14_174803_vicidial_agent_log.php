<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class VicidialAgentLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vicidial_agent_log', function (Blueprint $table) {
            $table->increments('agent_log_id');
            $table->string('user',20)->nullable();
            $table->string('server_ip',15);
            $table->dateTime('event_time')->default(null)->nullable();
            $table->string('campaign_id',8)->default(null)->nullable();
            $table->smallInteger('pause_sec')->default(0)->nullable();
            $table->smallInteger('wait_sec')->default(0)->nullable();
            $table->smallInteger('talk_sec')->default(0)->nullable();
            $table->smallInteger('dispo_sec')->default(0)->nullable();
            $table->string('status',6)->default(null)->nullable();
            $table->string('user_group',20)->default(null)->nullable();
            $table->smallInteger('dead_sec')->default(0)->nullable();
            $table->string('uniqueid',20)->nullable();
            $table->string('pause_type',20)->default("UNDEFINED")->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('vicidial_agent_log');
    }
}
