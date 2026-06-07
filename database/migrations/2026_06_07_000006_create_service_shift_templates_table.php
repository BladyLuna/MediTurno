<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_shift_templates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('hospital_service_id')->constrained()->restrictOnDelete();
            $table->foreignId('shift_template_id')->constrained()->restrictOnDelete();
            $table->string('custom_code', 20)->nullable();
            $table->string('custom_name')->nullable();
            $table->time('custom_start_time')->nullable();
            $table->time('custom_end_time')->nullable();
            $table->string('custom_color', 7)->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('hospital_service_id');
            $table->index('shift_template_id');
            $table->index('active');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_shift_templates');
    }
};
