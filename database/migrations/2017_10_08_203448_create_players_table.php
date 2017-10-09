<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlayersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('players', function (Blueprint $table) {
            $table->increments('id');
            $table->string('surname')->nullable()->default(null);
            $table->string('first_name')->nullable()->default(null);
            $table->string('email')->nullable()->default(null);
            $table->string('adres')->nullable()->default(null);
            $table->integer('postalcode')->nullable()->default(null);
            $table->string('city')->nullable()->default(null);
            $table->ipAddress('ip');
            $table->timestamp('start');
            $table->timestamp('end')->nullable()->default(null);
            $table->boolean('disqualified')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('players');
    }
}
