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
        Schema::create('candidate_interviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')->constrained('candidate_informations')->onDelete('cascade');
            $table->foreignId('interviewer')->constrained('users')->onDelete('cascade');
            $table->foreignId('position_id')->constrained('positions')->onDelete('cascade');
            $table->date('interview_date')->nullable(); // auto-filled later
            $table->decimal('viva_marks', 5, 2);
            $table->decimal('written_marks', 5, 2)->nullable();
            $table->decimal('mcq_marks', 5, 2)->nullable();
            $table->decimal('total_marks', 6, 2)->nullable(); // auto-computed
            $table->text('recommendation_note')->nullable();
            $table->enum('selection', ['Final Selected', 'Rejected'])->nullable();
            $table->text('interviewer_comments')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_interviews');
    }
};
