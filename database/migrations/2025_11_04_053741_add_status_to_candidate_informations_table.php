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
        Schema::table('candidate_informations', function (Blueprint $table) {
            $table->enum('status', [
                'Pending',
                'Short Listed',
                'Rejected',
                'Waiting List',
                'Final Selected'
            ])->default('Pending')->after('picture');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('candidate_informations', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
