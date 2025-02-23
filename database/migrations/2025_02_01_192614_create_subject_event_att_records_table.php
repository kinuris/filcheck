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
        Schema::create('subject_event_att_records', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_info_id')
                ->references('id')
                ->on('student_infos');

            $table->foreignId('subject_event_attendance_id')
                ->references('id')
                ->on('subject_event_attendances');

            $table->enum('type', ['ENTER', 'EXIT']);
            $table->time('time');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('subject_event_att_records');
    }
};
