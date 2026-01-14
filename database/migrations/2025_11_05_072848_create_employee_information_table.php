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
        if (Schema::hasTable('employee_informations')) {
            return;
        }

        Schema::create('employee_informations', function (Blueprint $table) {
            $table->id();

            // 🔗 Foreign Keys
            $table->foreignId('employee_id')->constrained('employees')->onDelete('cascade');
            $table->foreignId('department_id')->nullable()->constrained('departments')->onDelete('set null');
            $table->foreignId('sub_department_id')->nullable()->constrained('sub_departments')->onDelete('set null');

            // 📅 Dates
            $table->date('joining_date');
            $table->date('hire_date');
            $table->date('rehire_date')->nullable();

            // 🆔 Employee Info
            $table->string('id_card_no')->unique()->nullable();
            $table->integer('daily_working_hours')->nullable();

            // 💰 Pay Review
            $table->enum('pay_review', ['Six Month', 'One Year', 'Two Year'])->default('One Year');
            $table->text('pay_review_note')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_information');
    }
};
