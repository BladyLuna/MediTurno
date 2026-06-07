<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('hospital_service_id')->constrained()->restrictOnDelete();
            $table->string('ci', 50);
            $table->string('full_name');
            $table->string('position');
            $table->string('phone', 50)->nullable();
            $table->string('email')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index('ci');
            $table->index('full_name');
            $table->index('hospital_service_id');
            $table->index('user_id');
            $table->index('active');
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('staff');
    }
};
