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
        Schema::create('relhistories', function (Blueprint $table) {
            $table->id();
            $table->string("citerne");
            $table->double("stock_theo");
            $table->double("stock_rel");
            $table->double("ecart");
            $table->string("region");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relhistories');
    }
};
