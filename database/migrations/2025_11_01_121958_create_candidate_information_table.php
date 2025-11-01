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
        Schema::create('candidate_informations', function (Blueprint $table) {
            $table->id();

            // Unique apply id (20 chars) auto-generated in model
            $table->string('candidate_apply_id', 32)->unique();

            // Position (foreign key to positions table)
            $table->foreignId('position_id')->nullable()
                  ->constrained('positions')
                  ->nullOnDelete();

            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('alternative_phone')->nullable();

            $table->text('present_address')->nullable();
            $table->text('permanent_address')->nullable();

            $table->string('division')->nullable();
            $table->string('city')->nullable();
            $table->unsignedInteger('post_code')->nullable();

            // store picture filename/path
            $table->string('picture')->nullable();

            $table->timestamps();

            // Indexes
            $table->index('position_id');
            $table->index('candidate_apply_id');
            $table->index('email');
            $table->index('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_informations');
    }
};
