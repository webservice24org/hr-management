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
        Schema::table('employee_performances', function (Blueprint $table) {
            $table->json('section_a')->nullable()->after('review_period');
            $table->json('section_b')->nullable()->after('section_a');
            $table->boolean('is_locked')->default(false)->after('overall_comment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employee_performances', function (Blueprint $table) {
            $table->dropColumn(['section_a', 'section_b', 'is_locked']);
        });
    }
};
