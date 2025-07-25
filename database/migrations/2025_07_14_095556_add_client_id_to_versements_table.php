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
        Schema::table('versements', function (Blueprint $table) {
            //
            $table->unsignedBigInteger("client_id")->nullable();
            $table->string("is_associated")->nullable();
            $table->foreign("client_id")->on("clients")->references("id")->onDelete("cascade");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('versements', function (Blueprint $table) {
            //
        });
    }
};
