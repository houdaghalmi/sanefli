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
        Schema::create('favs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_user');
        $table->unsignedBigInteger('id_recette');
        $table->timestamps();

        $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('id_recette')->references('id')->on('recettes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('favs');
    }
};
