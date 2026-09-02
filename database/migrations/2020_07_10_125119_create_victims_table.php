<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVictimsTable extends Migration
{
    public function up(): void
    {
        Schema::create('victims', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('age');
            $table->char('sex', 1);
            $table->boolean('conscious');
            $table->boolean('fatal');
            $table->unsignedBigInteger('rescuer_id');
            $table->foreign('rescuer_id')->references('id')->on('rescuers');
            $table->unsignedBigInteger('occurrence_id');
            $table->foreign('occurrence_id')->references('id')->on('occurrences')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('victims');
    }
}
