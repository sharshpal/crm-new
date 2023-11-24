<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserTimelog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_timelog', function (Blueprint $table) {
            $table->id();
            $table->decimal("ore",10,2)->default(0.0);
            $table->integer('minuti')->default(0.0);
            $table->integer('user');

            $table->integer('campagna')->nullable();
            $table->date("period");

            $table->foreign('user')
                ->references('id')
                ->on("crm_user")
                ->onDelete('cascade');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_timelog');
    }
}
