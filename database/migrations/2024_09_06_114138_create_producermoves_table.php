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
        Schema::create('producermoves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_citerne");
            $table->string("type");
            $table->float("qty");
            $table->string("bordereau");
            $table->string("region");
            $table->foreign("id_citerne")->references("id")->on("citernes")->onDelete("CASCADE");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('producermoves');
    }
};
