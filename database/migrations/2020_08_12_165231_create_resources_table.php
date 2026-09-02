<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourcesTable extends Migration
{
    public function up(): void
    {
        Schema::create('resources', function (Blueprint $table) {
            $table->id();
            $table->string('who');
            $table->string('where');
            $table->string('how');
            $table->string('what');
            $table->unsignedBigInteger('occurrence_id');
            $table->foreign('occurrence_id')->references('id')->on('occurrences')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resources');
    }
}
