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
        Schema::create('schedule_attendance_records', function (Blueprint $table) {
            $table->id();

            $table->foreignId('room_schedule_id')
                ->references('id')
                ->on('room_schedules')
                ->cascadeOnDelete();

            $table->foreignId('student_info_id')
                ->references('id')
                ->on('student_infos')
                ->cascadeOnDelete();

            $table->enum('type', ['IN', 'OUT']);
            $table->date('day');
            $table->time('time');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_attendance_records');
    }
};
