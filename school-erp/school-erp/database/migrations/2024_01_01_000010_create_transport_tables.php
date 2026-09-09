<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transport_routes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('school_id')->constrained('schools')->cascadeOnDelete();
            $table->string('route_name');
            $table->string('vehicle_no')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('driver_phone')->nullable();
            $table->decimal('fare', 10, 2)->default(0);
            $table->timestamps();
        });

        Schema::create('student_transport', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transport_route_id')->constrained('transport_routes')->cascadeOnDelete();
            $table->foreignId('student_id')->constrained('students')->cascadeOnDelete();
            $table->date('assigned_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_transport');
        Schema::dropIfExists('transport_routes');
    }
};
