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
        Schema::create('invoicetraces', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_invoice");
            $table->unsignedBigInteger("id_article");
            $table->integer("qty");
            $table->float("unit_price");
            $table->string("region");
            $table->foreign("id_invoice")->references("id")->on("invoices")->onDelete("cascade");
            $table->foreign("id_article")->references("id")->on("articles")->onDelete("cascade");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoicetraces');
    }
};
