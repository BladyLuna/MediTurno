<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shift_change_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shift_assignment_id')->constrained()->restrictOnDelete();
            $table->foreignId('requested_by')->constrained('users')->restrictOnDelete();
            $table->foreignId('reviewed_by')->nullable()->constrained('users')->nullOnDelete();
            $table->text('reason');
            $table->string('status')->default('pending');
            $table->text('review_notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('shift_assignment_id');
            $table->index('requested_by');
            $table->index('reviewed_by');
            $table->index('status');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shift_change_requests');
    }
};
