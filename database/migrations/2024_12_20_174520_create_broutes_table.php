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
        Schema::create('broutes', function (Blueprint $table) {
            $table->id();
            $table->string("matricule");
            $table->string("depart");
            $table->string("arrivee");
            $table->string("date_depart");
            $table->string("date_arrivee");
            $table->string("nom_chauffeur");
            $table->string("permis");
            $table->string("aide_chauffeur");
            $table->string("contact");
            $table->text("details");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('broutes');
    }
};