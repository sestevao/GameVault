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
        Schema::table('console_owners', function (Blueprint $table) {
            $table->dropColumn(['cover', 'image']);

            // Add cover and additional cover foreign keys
            $table->unsignedBigInteger('cover_id')->nullable();
            $table->unsignedBigInteger('additional_cover_id')->nullable();

            // Add foreign key constraints to reference the images table
            $table->foreign('cover_id')->references('id')->on('images')->onDelete('set null');
            $table->foreign('additional_cover_id')->references('id')->on('images')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('console_owners', function (Blueprint $table) {
            $table->string('cover')->nullable();
            $table->string('image')->nullable();

            // Remove the foreign key constraints
            $table->dropForeign(['cover_id']);
            $table->dropForeign(['additional_cover_id']);

            // Drop the columns
            $table->dropColumn('cover_id');
            $table->dropColumn('additional_cover_id');
        });
    }
};
