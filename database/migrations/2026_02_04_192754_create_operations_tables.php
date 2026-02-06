<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('maintenance_requests');
        Schema::dropIfExists('attendance');
        Schema::dropIfExists('staff');

        // Staff Table
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('role'); // manager, reception, housekeeping, security
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('qr_code')->unique()->nullable();
            $table->string('status')->default('active'); // active, inactive
            $table->timestamps();
        });

        // Attendance Table
        Schema::create('attendance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained('staff')->onDelete('cascade');
            $table->date('date');
            $table->timestamp('check_in_time')->nullable();
            $table->timestamp('check_out_time')->nullable();
            $table->string('status')->default('present'); // present, absent, late, half_day
            $table->timestamps();
        });

        // Maintenance Requests Table
        Schema::create('maintenance_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
            $table->string('reported_by')->nullable();
            $table->text('issue_description');
            $table->string('priority')->default('medium'); // low, medium, high, critical
            $table->string('status')->default('pending'); // pending, in_progress, resolved
            $table->timestamp('resolved_at')->nullable();
            $table->timestamps();
        });

        // Expenses Table
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->string('category'); // maintenance, salary, utilities, other
            $table->decimal('amount', 10, 2);
            $table->string('description')->nullable();
            $table->date('date');
            $table->foreignId('incurred_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('maintenance_requests');
        Schema::dropIfExists('attendance');
        Schema::dropIfExists('staff');
    }
};
