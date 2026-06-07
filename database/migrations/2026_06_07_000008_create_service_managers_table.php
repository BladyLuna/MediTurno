<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_managers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->restrictOnDelete();
            $table->foreignId('hospital_service_id')->constrained()->restrictOnDelete();
            $table->timestamps();
            $table->softDeletes();

            $table->index('user_id');
            $table->index('hospital_service_id');
            $table->index(['user_id', 'hospital_service_id']);
            $table->index('deleted_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_managers');
    }
};
