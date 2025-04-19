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
        Schema::create('invoices_versement', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("versement_id");
            $table->unsignedBigInteger("invoices_id");
            $table->foreign("versement_id")->references("id")->on("versements")->onDelete("cascade");
            $table->foreign("invoices_id")->references("id")->on("invoices")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices_versement');
    }
};
