<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVictimsProblems extends Migration
{
    public function up(): void
    {
        Schema::create('victims-problems', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('victim_id');
            $table->foreign('victim_id')->references('id')->on('victims');
            $table->unsignedBigInteger('problem_id');
            $table->foreign('problem_id')->references('id')->on('problems');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('victims-problems');
    }
}
