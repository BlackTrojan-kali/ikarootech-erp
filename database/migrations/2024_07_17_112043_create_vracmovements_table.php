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
        Schema::create('vracmovements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("citerne_id");
            $table->unsignedBigInteger("vracstock_id");
            
            $table->string("qty");
            $table->text("matricule");
            $table->string("service");
            $table->foreign("citerne_id")->references("id")->on("citernes")->onDelete("cascade");
            $table->foreign("vracstock_id")->references("id")->on("vracstocks")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vracmovements');
    }
};
