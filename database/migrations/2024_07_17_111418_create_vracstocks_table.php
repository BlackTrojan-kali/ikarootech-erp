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
        Schema::create('vracstocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("citerne_id");
            $table->foreign("citerne_id")->references("id")->on("citernes")->onDelete("cascade");
            $table->float("stock_theo");
            $table->float("stock_rel");
            $table->string("region");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vracstocks');
    }
};
