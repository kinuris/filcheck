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
        Schema::create('subject_event_attendances', function (Blueprint $table) {
            $table->id();

            $table->foreignId('room_schedule_id')
                ->references('id')
                ->on('room_schedules');

            $table->foreignId('event_id')
                ->references('id')
                ->on('events');   

            $table->foreignId('student_info_id')
                ->references('id')
                ->on('student_infos');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_event_attendances');
    }
};
