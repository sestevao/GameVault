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
        Schema::table('consoles', function (Blueprint $table) {
            $table->dropColumn('image');

            // Add cover and additional cover foreign keys
            $table->unsignedBigInteger('cover_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consoles', function (Blueprint $table) {
            $table->string('image')->nullable();

            // Remove the foreign key constraints
            $table->dropForeign(['cover_id']);
        });
    }
};
