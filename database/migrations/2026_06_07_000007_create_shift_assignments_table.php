<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shift_assignments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('staff_id')->constrained('staff')->restrictOnDelete();
            $table->foreignId('hospital_service_id')->constrained()->restrictOnDelete();
            $table->foreignId('service_shift_template_id')->constrained()->restrictOnDelete();
            $table->date('assignment_date');
            $table->dateTime('start_at');
            $table->dateTime('end_at');
            $table->string('status')->default('assigned');
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('staff_id');
            $table->index('hospital_service_id');
            $table->index('service_shift_template_id');
            $table->index('assignment_date');
            $table->index('start_at');
            $table->index('end_at');
            $table->index('status');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shift_assignments');
    }
};
