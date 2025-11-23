<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExamResultsTable extends Migration
{
    public function up()
    {
        Schema::create('exam_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('exam_id')->constrained()->onDelete('cascade');
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->decimal('obtained_marks', 5, 2);
            $table->string('grade')->nullable();
            $table->decimal('percentage', 5, 2)->nullable();
            $table->text('remarks')->nullable();
            $table->enum('status', ['pass', 'fail', 'absent'])->default('pass');
            $table->timestamps();

            $table->unique(['exam_id', 'student_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('exam_results');
    }
}
