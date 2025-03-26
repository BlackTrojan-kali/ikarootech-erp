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
        Schema::create('transmits', function (Blueprint $table) {
            $table->id();
            $table->integer("state");
            $table->string("type");
            $table->string("service");
            $table->float("qty");
            $table->string("destination");
            $table->string("bordereau");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transmits');
    }
};
