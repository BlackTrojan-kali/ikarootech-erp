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
        Schema::create('depotages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_citerne_mobile");
            $table->unsignedBigInteger("id_citerne_fixe");
            $table->double("qty");
            $table->string("matricule");
            $table->string("region");
            $table->foreign("id_citerne_mobile")->references("id")->on("citernes")->onDelete("cascade");
            $table->foreign("id_citerne_fixe")->references("id")->on("citernes")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('depotages');
    }
};
