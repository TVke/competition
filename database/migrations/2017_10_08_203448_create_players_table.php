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
            $table->string('last_name')->nullable()->default(null);
            $table->string('first_name')->nullable()->default(null);
            $table->string('email')->nullable()->default(null);
            $table->mediumText('address')->nullable()->default(null);
            $table->string('postcode')->nullable()->default(null);
            $table->string('city')->nullable()->default(null);
            $table->ipAddress('ip');
            $table->decimal('start',15,4)->nullable()->default(null);
            $table->decimal('end',15,4)->nullable()->default(null);
            $table->integer('time')->nullable()->default(null);
            $table->boolean('possible_dis')->default(0);
            $table->boolean('disqualified')->default(0);
            $table->string('safety_token')->default("");
            $table->string('friend_token')->nullable()->default(null);
            $table->string('friend_email')->nullable()->default(null);
	        $table->boolean('mail_opened')->default(0);
	        $table->boolean('no_more')->default(0);
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
