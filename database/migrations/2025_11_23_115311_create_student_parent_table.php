<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentParentTable extends Migration
{
    public function up()
    {
        Schema::create('student_parent', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('parent_id')->constrained()->onDelete('cascade');
            $table->string('relationship')->nullable();
            $table->boolean('is_primary_contact')->default(false);
            $table->timestamps();

            $table->unique(['student_id', 'parent_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_parent');
    }
}
