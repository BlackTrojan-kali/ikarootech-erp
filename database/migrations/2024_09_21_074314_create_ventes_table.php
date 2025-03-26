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
        Schema::create('ventes', function (Blueprint $table) {
            $table->id();
            $table->string("customer");
            $table->string("address");
            $table->integer("number");
            $table->float("prix_6");
            $table->float("qty_6");
            $table->string("prix_12");
            $table->float("qty_12");
            $table->float("prix_50");
            $table->float("qty_50");
            $table->integer("prix_unitaire");
            $table->bigInteger("prix_total")->nullable();
            $table->string("region");
            $table->string("currency");
            $table->string("service");
            $table->string("type");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventes');
    }
};
