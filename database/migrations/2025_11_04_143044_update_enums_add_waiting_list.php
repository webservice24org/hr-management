<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('candidate_interviews', function (Blueprint $table) {
            $table->enum('selection', ['Final Selected', 'Rejected', 'Waiting List'])->nullable()->change();
        });

        Schema::table('candidate_informations', function (Blueprint $table) {
            $table->enum('status', [
                'Pending',
                'Short Listed',
                'Rejected',
                'Waiting List',
                'Final Selected'
            ])->default('Pending')->change();
        });
    }

    public function down(): void
    {
        Schema::table('candidate_interviews', function (Blueprint $table) {
            $table->enum('selection', ['Final Selected', 'Rejected'])->nullable()->change();
        });

        Schema::table('candidate_informations', function (Blueprint $table) {
            $table->enum('status', [
                'Pending',
                'Short Listed',
                'Rejected',
                'Final Selected'
            ])->default('Pending')->change();
        });
    }
};
