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
        // ✅ Update enum values (MySQL specific)
        DB::statement("ALTER TABLE candidate_interviews MODIFY selection ENUM('Final Selected', 'Rejected', 'Waiting List') NULL");
    }

    public function down(): void
    {
        // 🔙 Revert back to original enum options
        DB::statement("ALTER TABLE candidate_interviews MODIFY selection ENUM('Final Selected', 'Rejected') NULL");
    }

};
