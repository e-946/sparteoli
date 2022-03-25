<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOccurrencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('occurrences', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->time('call_time');
            $table->time('arrival_time');
            $table->time('end_time');
            $table->unsignedBigInteger('meanused_id');
            $table->foreign('meanused_id')->references('id')->on('meanuseds');
            $table->string('zip_code');
            $table->string('address');
            $table->string('neighborhood');
            $table->string('city');
            $table->string('state');
            $table->string('requester');
            $table->string('requester_phone');
            $table->text('resume');
            $table->unsignedBigInteger('placefreature_id');
            $table->foreign('placefreature_id')->references('id')->on('placefreatures');
            $table->unsignedBigInteger('placeuse_id');
            $table->foreign('placeuse_id')->references('id')->on('placeuses');
            $table->boolean('place_preservation');
            $table->string('filler_name');
            $table->string('filler_register');
            $table->string('filler_patent');
            $table->unsignedBigInteger('type_id');
            $table->foreign('type_id')->references('id')->on('types');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('occurrences');
    }
}
