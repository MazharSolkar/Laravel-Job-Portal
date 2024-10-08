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
        Schema::create('job_applications', function (Blueprint $table) {
            $table->id();
            // Foreign keys for job and user tables are automatically referenced by following Laravel's naming convention
            $table->foreignId('job_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // Since the 'employe_id' column does not follow Laravel's default foreign key naming convention (which expects 'user_id' for referencing the 'users' table), we need to explicitly specify the 'users' table for the foreign key constraint.
            $table->foreignId('employer_id')->constrained('users')->onDelete('cascade');
            $table->timestamp('applied_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_applications');
    }
};
