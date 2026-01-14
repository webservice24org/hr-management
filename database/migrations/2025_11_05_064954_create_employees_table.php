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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('candidate_id')->constrained('candidate_informations')->onDelete('cascade');
            $table->string('national_id')->nullable();
            $table->string('passport_no')->nullable();
            $table->string('driving_license')->nullable();
            $table->enum('employee_type', ['Full time', 'Part time', 'Contractual', 'Daily worker'])->default('Full time');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('employees');
        Schema::enableForeignKeyConstraints();
    }
};
