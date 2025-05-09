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
        Schema::create('event_attendance_records', function (Blueprint $table) {
            $table->id();

            $table->foreignId('student_info_id')
                ->references('id')
                ->on('student_infos')
                ->onDelete('cascade');
            
            $table->foreignId('event_id')
                ->references('id')
                ->on('events')
                ->onDelete('cascade');

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
        Schema::dropIfExists('event_attendance_records');
    }
};
