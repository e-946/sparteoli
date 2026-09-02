<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOccurrenceFireProtection extends Migration
{
    public function up(): void
    {
        Schema::create('occurrence-fireprotection', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('occurrence_id');
            $table->foreign('occurrence_id')->references('id')->on('occurrences');
            $table->unsignedBigInteger('fireprotection_id');
            $table->foreign('fireprotection_id')->references('id')->on('fireprotections');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('occurrence-fireprotection');
    }
}
