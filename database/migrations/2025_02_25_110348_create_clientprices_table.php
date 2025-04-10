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
        Schema::create('clientprices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_cat");
            $table->unsignedBigInteger("id_article");
            $table->float("unite_price");
            $table->float("consigne_price");
            $table->string("region");
            $table->foreign("id_cat")->references("id")->on("clientcats")->onDelete("cascade");
            $table->foreign("id_article")->references("id")->on("articles")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientprices');
    }
};