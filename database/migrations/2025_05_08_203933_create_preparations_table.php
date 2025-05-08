<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('preparations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_recette');
            $table->unsignedBigInteger('id_ingredient');
            $table->string('quantity');
            $table->integer('temps_de_preparation'); // en minutes
            $table->text('description')->nullable();
            $table->timestamps();
    
            $table->foreign('id_recette')->references('id')->on('recettes')->onDelete('cascade');
            $table->foreign('id_ingredient')->references('id')->on('ingredients')->onDelete('cascade');
    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('preparations');
    }
};
