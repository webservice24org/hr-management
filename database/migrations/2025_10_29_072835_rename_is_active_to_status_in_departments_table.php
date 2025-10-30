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
        Schema::table('departments', function (Blueprint $table) {
            // Rename column
            $table->renameColumn('is_active', 'status');
        });

        // Change type from boolean to string (optional)
        Schema::table('departments', function (Blueprint $table) {
            $table->string('status')->default('active')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->renameColumn('status', 'is_active');
        });

        Schema::table('departments', function (Blueprint $table) {
            $table->boolean('is_active')->default(true)->change();
        });
    }
};
