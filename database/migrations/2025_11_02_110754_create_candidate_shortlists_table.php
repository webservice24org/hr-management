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
        Schema::create('candidate_shortlists', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('candidate_id');
            $table->string('candidate_apply_id')->nullable();
            $table->date('interview_date')->nullable();
            $table->unsignedBigInteger('listed_by')->nullable();
            $table->timestamps();

            // Foreign keys
            $table->foreign('candidate_id')
                ->references('id')
                ->on('candidate_informations')
                ->onDelete('cascade');

            $table->foreign('listed_by')
                ->references('id')
                ->on('users')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_shortlists');
    }
};
