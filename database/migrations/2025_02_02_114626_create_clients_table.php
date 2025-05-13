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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string("nom");
            $table->string("prenom");
            $table->double("numero");
            $table->string("address")->nullable();
            $table->string("region");
            $table->string("email")->nullable();
            $table->string("registre_commerce")->nullable();
            $table->string("numero_unique")->nullable();
            $table->unsignedBigInteger("id_clientcat");
            $table->foreign("id_clientcat")->on("clientcats")->references("id")->onDelete("CASCADE");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
