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
        Schema::create('solutions_student_for_homework', function (Blueprint $table) {
            $table->id();

            // foreign keys
            $table->unsignedBigInteger('student_id');
            $table->foreign('student_id')
                ->references('id')
                ->on('students')
                ->onDelete('cascade');

            $table->unsignedBigInteger('homework_id');
            $table->foreign('homework_id')
                ->references('id')
                ->on('homeworks')
                ->onDelete('cascade');

            $table->string('homework_solution_file');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('solutions_students_for_homeworks');
    }
};
