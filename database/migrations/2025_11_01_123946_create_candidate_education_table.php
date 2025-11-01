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
        Schema::create('candidate_educations', function (Blueprint $table) {
            $table->id();

            // Foreign key to candidate_information
            $table->foreignId('candidate_id')
                ->constrained('candidate_informations')
                ->onDelete('cascade'); // delete educations when candidate deleted

            $table->string('degree'); // SSC, HSC, Honours, Masters, etc.
            $table->string('institution')->nullable();
            $table->string('result')->nullable();
            $table->text('comments')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_educations');
    }
};
