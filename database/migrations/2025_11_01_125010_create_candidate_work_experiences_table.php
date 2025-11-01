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
        Schema::create('candidate_work_experiences', function (Blueprint $table) {
            $table->id();

            // Link to candidate_information
            $table->foreignId('candidate_id')
                ->constrained('candidate_informations')
                ->onDelete('cascade'); // when candidate deleted → remove experiences too

            $table->string('company_name');
            $table->string('working_period')->nullable(); // e.g. Jan 2020 - Dec 2023
            $table->text('duties')->nullable();           // key responsibilities
            $table->string('supervisor')->nullable();     // supervisor name

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('candidate_work_experiences');
    }
};
