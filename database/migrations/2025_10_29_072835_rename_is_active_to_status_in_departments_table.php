<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('departments', 'status')) {
            if (Schema::hasColumn('departments', 'is_active')) {
                Schema::table('departments', function (Blueprint $table) {
                    $table->renameColumn('is_active', 'status');
                });
            } else {
                Schema::table('departments', function (Blueprint $table) {
                    $table->string('status')->default('active');
                });
            }
        }

        Schema::table('departments', function (Blueprint $table) {
            $table->string('status')->default('active')->change();
        });

        DB::table('departments')->where('status', '1')->update(['status' => 'active']);
        DB::table('departments')->where('status', '0')->update(['status' => 'inactive']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasColumn('departments', 'status')) {
            // Update values before changing type to avoid data type mismatch
            DB::table('departments')->where('status', 'active')->update(['status' => '1']);
            DB::table('departments')->where('status', 'inactive')->update(['status' => '0']);

            Schema::table('departments', function (Blueprint $table) {
                $table->boolean('status')->default(true)->change();
            });

            Schema::table('departments', function (Blueprint $table) {
                $table->renameColumn('status', 'is_active');
            });
        }
    }
};
