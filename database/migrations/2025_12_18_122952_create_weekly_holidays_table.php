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
        Schema::create('weekly_holidays', function (Blueprint $table) {
            $table->id();
            $table->string('day_name');

            // Numeric day (0=Sunday … 6=Saturday)
            $table->unsignedTinyInteger('day_number');

            // Active or not
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            $table->unique('day_number'); // prevent duplicates
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weekly_holidays');
    }
};
